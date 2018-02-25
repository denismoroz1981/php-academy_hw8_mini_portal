<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 25.02.18
 * Time: 19:43
 */

require_once 'includes' . DIRECTORY_SEPARATOR . 'functions.php';

$arrNews = getNewsFullList();

echo "<table cellpadding='5px'>";
echo "<th>Date</th>";
echo "<th>Name</th>";
echo "<th>Newsreal</th>";

foreach ($arrNews as $k => $v) {
    echo "<tr>";
    echo "<td>";
    echo var_export($v["news_date"],1);
    echo "</td>";
    echo "<td>";
    echo ' <a href="?page=news_detailed&news_id='.var_export($k,1).'">'.
    var_export($v["news_name"],1).'</a> ';
    echo "</td>";
    echo "<td>";
    echo var_export($v["news_anons"],1);
    echo "</td>";
    echo "/<tr>";
}
echo "</table>";