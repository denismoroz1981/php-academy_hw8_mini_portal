<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 25.02.18
 * Time: 20:00
 */

require_once 'includes' . DIRECTORY_SEPARATOR . 'functions.php';

$newsDetails=getNewsDetails($_REQUEST["news_id"]);

echo var_export($newsDetails["news_date"],1).'<br><br>';
echo '<b>'.var_export($newsDetails["news_name"],1).'</b>'.'<br><br>';
echo var_export($newsDetails["news_fulltext"],1).'</br><br>';
echo '<i>'.var_export($newsDetails["news_source"],1).'</i>'.'<br><br>';
