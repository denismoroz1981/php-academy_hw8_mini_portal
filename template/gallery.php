<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 04.03.18
 * Time: 18:12
 */

define('FILE_SIZE_MAX', 1024*1024*2);

require_once 'includes'.DIRECTORY_SEPARATOR.'functions_gallery.php';

echo '<p>$_FILES: '.var_export($_FILES,1).'</p>';

if (!empty($_FILES)) {

    $uploadDir = dirname(__FILE__).DIRECTORY_SEPARATOR.
        '..'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'gallery1'.DIRECTORY_SEPARATOR;
    if ($_POST["new_folder"]!=='') {
        $uploadDir.= $_POST["new_folder"].DIRECTORY_SEPARATOR;
        } else {
        $uploadDir.= $_POST["folder"].DIRECTORY_SEPARATOR;
    }
    // die('<pre>'.print_r($_POST,1).'</pre>');
    uploadFiles($_FILES,$uploadDir,FILE_SIZE_MAX);
}


echo '<hr>';

echo '<form action="" method="post" enctype="multipart/form-data">' .
    '<div><label id="ufile">Choose file <i>*</i>: </label> 
        <input type="file" id="ufile" name="ufile"></div>'.
    '<input type="hidden" name="MAX_FILE_SIZE" value="'.FILE_SIZE_MAX.'">'.
    '<p>Save in existing folder: ';

echo displayFolder();

echo ' or in new folder: '.
    '<input type="text" name="new_folder" placeholder="enter folder name"></p>'.
    '<div><input type="submit" value="Upload file"></div>'.
    '<div><i>*</i>-required fields</div>'.

    '</form>';
echo '<hr>';

echo displayGallery1();
