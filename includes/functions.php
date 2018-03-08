<?php

/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 23.02.2018
 * Time: 20:16
 */

function getTopNavigation()
{
    $navHtml = '';

    $pages = [
        ['href' => '?page=home', 'title' => 'Home page'],
        ['href' => '?page=gallery', 'title' => 'Gallery'],
        ['href' => '?page=contact', 'title' => 'Contact us'],
        ['href' => '?page=news', 'title' => 'News'],

    ];

    if (!empty($pages)) {
        $navHtml .= '<ul>';
        foreach ($pages as $i => $page) {
            $navHtml .= '<li><a href="'. $page['href'] .'">'. $page['title'] .'</a></li>';
        }
        $navHtml .= '</ul>';
    }

    return $navHtml;
}


function getNewsFullList() {
    require_once 'includes' . DIRECTORY_SEPARATOR . 'news_database.php';
    $arrNews = getNewsDatabase();
    return $arrNews;
}

function getNewsDetails($newsNum) {
    require_once 'includes' . DIRECTORY_SEPARATOR . 'news_database.php';
    $arrNews = getNewsDatabase();
    return $arrNews[$newsNum];

}

$errors = [];
$contactMessages = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.
'files'.DIRECTORY_SEPARATOR.'contact.dat');
//die($contactMessages);

function ValidateContactData($data)
{

    global $errors;
    $validData=true;

    $data['uname'] = trim(strip_tags($data['uname']));
    if (empty($data["uname"])) {
        $errors[] = "Username is required.";
    } elseif
    (strlen($data['uname']) > 255) {
        $errors[] = "Username is too long, > 255 characters";
    } elseif
    (strlen($data['uname']) < 2) {
        $errors[] = "Username is too short, < 2 characters";
    }
    if (empty($data["uemail"])) {
        $errors[] = "Email is required.";
    } else
        if (!filter_var($data["uemail"],FILTER_VALIDATE_EMAIL)){
            $errors[] = "Invalid Email format";
        }
    if (!empty($data['utel'])) {
        $data['utel'] = trim(preg_replace('|\D|', '', $data['utel']));
        if (strlen($data['utel']) < 10) {
            $errors[] = "Phone number must be at least 10 digits";
        } elseif
        (strlen($data['utel']) > 12) {
            $errors[] = "Phome number must be more than 12 digits";
        }
    }
    if (empty($data['umsg'])) {
        $errors[] = "Message can't be empty.";
        } else {
            $data['umsg'] = trim(strip_tags($data['umsg']));
            }
            if (strlen($data['umsg']) > 1024) {
                $errors[] = "Text is too long > 1024 characters";
            }

    if (empty($data['g-recaptcha-response'])) {
        $errors[]="Invalid captcha code";
    } else {
        $reqData = [
            'secret' => GOOGLE_SECRET_KEY,
            'response' => $data['g-recaptcha-response'],
            //'remoteip => $_SERVER["REMOTE_ADDR"],
        ];
        $reqData=http_build_query($reqData);
        $context_options = array (
            'http' => array (
                'method' => 'POST',
                'header'=> 'Content-type: application/x-www-form-urlencoded\r\n'
                .'Content-Length:' . strlen($reqData).'\r\n',
                'content' => $reqData,

            )
        );
        $context = stream_context_create($context_options);
        $resp = file_get_contents('https://www.google.com/recaptcha/api/siteverify',false,
            $context);
        if ($resp!==false) {
            $oResp = json_decode($resp);
            if ($oResp->success) {
            } else {
                $errors[] = "Wrong captcha code.";
            }
        echo __FUNCTION__." ".var_export($oResp,1);



        } else {
            $errors[]="Error validating captcha code";
        }
    }

    if (!empty($errors)) {
        $validData=false;
    }

    return $validData;

    }

function getErrors() {
    global $errors;
    $messages ="";
    if (!empty($errors)) {
        foreach ($errors as $err) {
            $messages .= '<p class="error danger-error">'.$err.'</p>';
        }
    }
    return $messages;
}

function addContactData($data) {
    global $contactMessages;

    $data["addedDt"] = date('Y-m-d H:i:s');
    $data["ref"] = $_SERVER['HTTP_REFERER'];
    $data["ref"] = $_SERVER['REMOTE_ADDR'];
    $data["ref"] = $_SERVER['HTTP_USER_AGENT'];

    $previouseMessages = _getCommentsAsArray();
    //echo var_export($previouseMessages);
    $newMessages = array_merge($previouseMessages,[$data]);
    $sMessages = serialize($newMessages);
    file_put_contents($contactMessages,$sMessages);

}

function _antimat($str) {
    if (strlen($str)) {
        return str_replace(
            ["test","hello"],
            ["t**t","h*"],
            $str);
    }

}

function getComments() {
    $messages = _getCommentsAsArray();
    $htmlMsgs = [];
    #Bootstrap comments template
    $htmlMsgs.= <<<EOG
    
    <style type="text/css">
.thumbnail {
    padding:0px;
}
.panel {
	position:relative;
}
.panel>.panel-heading:after,.panel>.panel-heading:before{
	position:absolute;
	top:11px;left:-16px;
	right:100%;
	width:0;
	height:0;
	display:block;
	content:" ";
	border-color:transparent;
	border-style:solid solid outset;
	pointer-events:none;
}
.panel>.panel-heading:after{
	border-width:7px;
	border-right-color:#f7f7f7;
	margin-top:1px;
	margin-left:2px;
}
.panel>.panel-heading:before{
	border-right-color:#ddd;
	border-width:8px;
}
    
</style>
    
<div class="container">
<div class="row">
<div class="col-sm-12">
<h3>Comments</h3>
</div><!-- /col-sm-12 -->
</div><!-- /row -->
<br>
<div class="row">
<div class="col-sm-1">
<!--<div class="thumbnail">
<img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
</div><!-- /thumbnail -->
</div><!-- /col-sm-1 -->

EOG;

    if ($messages) {
        foreach ($messages as $n => $m) {
            $htmlMsgs .='<div class="col-sm-5">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                        <strong>'.var_export($m["uname"],1).
                        '<br><a href="mailto:'.$m["uemail"].'">'.
                        '</strong> <span class="text-muted">'.var_export($m["addedDt"],1).
                        '</span></div><div class="panel-body">'.
                        var_export(_antimat($m["umsg"]),1).
                        '</div><!-- /panel-body -->
                        </div><!-- /panel panel-default -->
                        </div><!-- /col-sm-5 -->';

           # $htmlMsgs .= '<div class="message message-'.$n.'"><dl>
            #<dt>Added by <a href="mailto:'.$m["uemail"].'">'.$m["uname"].'</a>'.
            #' on '.$m["addedDt"].'</dt>'.
             #   '<dd>'._antimat($m["umsg"]).'</dd></dl></div>';
        }
    }
    return $htmlMsgs;

}

function _getCommentsAsArray() {
    global $contactMessages;
    $aComments=[];
    if (file_exists($contactMessages)) {
        $fData=file_get_contents($contactMessages);
        if (!empty($fData)) {
        $aComments = unserialize($fData);
        if ($aComments!==false) {
            return $aComments;
        }}
    }
    //var_export($aComments);
    return $aComments;

}