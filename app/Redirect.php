<?php
declare(strict_types = 1);

require_once 'URL.php';

class Redirect{
    public static function toOriginalURL(string $shortCode){
        $longURL = URL::getLongURLFromShortCode($shortCode);
        if(!$longURL)
            throw new \Exception("URL not found.");
        header("Location: " . $longURL);
    }
}