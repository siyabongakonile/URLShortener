<?php
require_once './app/Database.php';
require_once './app/URL.php';
require_once './app/Redirect.php';

// $url = new URL("https://test.test/ffgdgdggdg/dfgdfg/ggdgdg");
// $shortCode = $url->createUniqueShortCode($url);
// $url->setShortCode($shortCode);
// URL::add($url);

// $url = URL::getLongURLFromShortCode('snd21ly_v6r7ofa');

Redirect::toOriginalURL('snd21ly_v6r7ofa');

// var_dump($url);