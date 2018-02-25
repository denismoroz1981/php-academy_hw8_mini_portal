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