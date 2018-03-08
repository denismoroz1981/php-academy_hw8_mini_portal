<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 04.03.18
 * Time: 18:44
 */

$allowExt=[
    'jpg',
    'png',
    'jpeg',
    'gif',
    'svg',
    'JPG'
    ];

$allowMime = [
    'image/jpeg',
    'image/gif',
    'image/png',
    'image/svg',
];
$fileUploadErr = [];

$displayDir = dirname(__FILE__).DIRECTORY_SEPARATOR.
    '..'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'gallery1'.DIRECTORY_SEPARATOR;

$pathToFilesWeb = 'files'.DIRECTORY_SEPARATOR.'gallery1'.DIRECTORY_SEPARATOR;

$dirs = array_diff(scandir('files/gallery1'),array('..','.'));

function uploadFiles($files,$uploadDir,$maxFilesSize=2048) {

    global $allowExt, $fileUploadErr, $allowMime;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir,0777,true);//recursive creation (if subdirectory not exists, created
    }

    foreach ($files as $f1) {
        if ($f1['error']!=0) {
            $fileUploadErr[] = 'Upload file error: '.$f1['error'];
        }
        if ($f1['size']<=$maxFilesSize){
            $pInfo = pathinfo($f1['name']);
            $ext = strtolower($pInfo['extension']);
            if (!in_array($ext,$allowExt)){
                $fileUploadErr[]='Wrong file extension: '.$ext.
                    '. Allowed extensions are: '.var_export($allowExt,1);
            }
            $mime = mime_content_type($f1['tmp_name']);
            if (!in_array($mime,$allowMime)) {
                $fileUploadErr[]='Wrong mime type: '.$mime.
                    '. Allowed mime types are: '.var_export($allowMime,1);
            }
            $uploadFileFullName = $uploadDir.$f1["name"];
            if (file_exists($uploadFileFullName)) {
                $uploadFileFullName = $uploadDir.date('Y-m-d-H-i-s').'.'.$ext;

            }
            if (move_uploaded_file($f1['tmp_name'], $uploadFileFullName)){
                    echo '<p>Uploaded file to: '.$uploadFileFullName.'</p>';
                }


        } else {
            $fileUploadErr[]='File size '.$f1['size'].' exceeds maximum allowed: '.$maxFilesSize;
        }
    }
}

function displayGallery1() {
    global $displayDir, $allowExt, $pathToFilesWeb, $dirs;



    $galleryHtml = "";
    #Bootstrap gallery template
    $galleryHtml.=<<<EOG
    
    <style type="text/css">
    .gal {
	
	
	-webkit-column-count: 3; /* Chrome, Safari, Opera */
    -moz-column-count: 3; /* Firefox */
    column-count: 3;
	  
	
	}	
	.gal img{ width: 100%; padding: 7px 0;}
@media (max-width: 500px) {
		
		.gal {
	
	
	-webkit-column-count: 1; /* Chrome, Safari, Opera */
    -moz-column-count: 1; /* Firefox */
    column-count: 1;
	 
	}
	
	}
    
    </style>
    
    
    <div class="container">
    <h1>Pure Css Responsive Masonry Gallery</h1>
    <div class="col-md-12">
    <div class="row">
    <hr>
    <div class="gal"> 
EOG;

    $extList = '{*.'.implode(',*.',$allowExt).'}';
    foreach ($dirs as $k=>$folder) {
        $displayFolder=$displayDir.$folder.DIRECTORY_SEPARATOR;
        $imagesFiles = glob($displayFolder.$extList,GLOB_BRACE);
        if (!empty($imagesFiles)) {

        foreach ($imagesFiles as $k=>$file) {
            $imgName = basename($file);
            $galleryHtml .= '<img src="' . $pathToFilesWeb .$folder.DIRECTORY_SEPARATOR.$imgName .
                '" width=250 alt="">';

        }
    }}
     $galleryHtml.=<<<EOG
    </div>
	</div>
    </div>
    </div>
EOG;



    return $galleryHtml;
}

function displayFolder() {

    global $dirs;

    $htmlFolders ='<select name="folder">';
    foreach ($dirs as $k=>$folder) {
        $htmlFolders.='<option>'.print_r($folder,1).'</option>';
    }
    $htmlFolders .='</select>';

    return $htmlFolders;

}