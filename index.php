<?php

/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 23.02.2018
 * Time: 20:15
 * Что задано домой?

Взять архив занятия, добавить 2 страницы: список новостей, детальная страница новости в шаблон
 * мини сайта, который мы начали делать на занятии.

Добавить в асоциативный массив новости. Написать функциями получение одной новости,
 * списка новостей, сгенерировать навигацию. В шаблоне вывода списка новостей показывать:
 * дату новсти и название, а так же краткий текст из поля анонс.
 * В детальной странице новости показывать: дату, название, полный текст и источник новости.


 */

require_once 'includes' . DIRECTORY_SEPARATOR . 'functions.php';

$page = $_REQUEST['page'];

ob_start();

switch ($page)
{
    case 'gallery':
        $title = 'Gallery';
        $h1 = 'Gallery page #1 title';

        include_once 'template' . DIRECTORY_SEPARATOR . 'gallery.php';
        break;
    case 'contact':
        $title = 'Contact us';
        $h1 = 'Contact us page #1 title';

        include_once 'template' . DIRECTORY_SEPARATOR . 'contact.php';
        break;
    case '':
    case 'home':
    default:
        $title = 'Home page';
        $h1 = 'Home page #1 title';

        include_once 'template' . DIRECTORY_SEPARATOR . 'home.php';
        break;
    case "news":
        $title = "News";
        $h1 = "News page #1 title";
        include_once 'template' . DIRECTORY_SEPARATOR . 'news_list.php';
        break;
    case "news_detailed":
        $title = "News details";
        $h1 = "News details page #1 title";
        include_once 'template' . DIRECTORY_SEPARATOR . 'news_detailed.php';
        break;
}

$topNav = getTopNavigation();

$content = ob_get_contents();
ob_end_clean();

// echo $content;

include_once 'template' . DIRECTORY_SEPARATOR . '_layout.php';






