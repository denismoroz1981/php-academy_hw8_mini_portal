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
        ['href' => '?page=about', 'title' => 'About us'],
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

// TODO: подумать, как избавиться от лишней функции
function getNewsFullList() {
    return getNewsDetails();
}

function getNewsDetails($newsNum = null) {
    $arrNews = require_once 'includes' . DIRECTORY_SEPARATOR . 'news_database.php';
    if (!empty($newsNum)) {
        if (isset($arrNews[$newsNum])) {
            return $arrNews[$newsNum];
        }
    }
    return $arrNews;
}
