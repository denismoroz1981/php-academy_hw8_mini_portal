<?php

/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 23.02.2018
 * Time: 20:51
 */

//require_once 'includes' . DIRECTORY_SEPARATOR . 'functions.php';

define('GOOGLE_SECRET_KEY','6LegTEoUAAAAAGbzEkdscX5rQn8tS995MfvlwX3E');

if (!empty($_POST)) {
   // die ('<pre>'.print_r($_POST).'</pre>');
    if (validateContactData($_POST)) {
        addContactData($_POST);

    }
}

echo getErrors();
echo '<hr>';

$htmlForm = <<<EOG
<style type="text/css">
.content{
	margin-top: 50px;
}
.form-control-feedback{
	right: 10px;
}
input.error {
	border: 1px solid #ff0000;
}
label.error {
	color: #ff0000;
	font-weight: normal;
}
</style>
EOG;



echo $htmlForm;


echo '<form action="" method="post" id="form1">' .
        '<div><label id="uname">User name <i>*</i>: </label> 
        <input type="text" id="uname" name="uname"></div>' .
        '<div><label id="uemail">Email <i>*</i>: </label>
         <input type="email" id="uemail" name="uemail" placeholder="Email"></div>'.
        '<div><label id="utel">Phone: <i>*</i>: </label>
         <input type="text" id="utel" name="utel"></div>'.
        '<div><label id="umsg">Message <i>*</i>: <i>*</i>: </label><br>
         <textarea id="umsg" name="umsg"></textarea></div>'.
        '<div class="g-recaptcha" data-sitekey="6LegTEoUAAAAAMU76l7EziRYRF_RCa05qLLM3OU_"></div>'.
        '<div><input type="submit" value="Add comment"></div>'.
        '<div><i>*</i>-required fields</div>'.

        '</form>';
$htmlForm1=<<<EOG
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	
	<script src="/jv/dist/jquery.validate.js"></script>

	<script>
$(function(){
	$('#form1').validate({
		rules: {
			uname: {
				required: true,
				minlength: 2
			}
			
		},
		messages: {
			uname: {
				required: "Поле \'User name\' обязательно к заполнению",
				minlength: "Введите не менее 2-х символов в поле \'User name\'"
			}
			
			        		
	});
});
	</script>
EOG;

echo $htmlForm1;


echo '<hr>';

echo getComments();


