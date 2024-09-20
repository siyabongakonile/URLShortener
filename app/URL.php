<?php
declare(strict_types = 1);

class URL{
    private string $longURL;

    private string $shortCode;

    private string $acceptedChars = "abcdefghijklmnopqrstuvwxyz012345678_.";

    public function __construct(string $longURL){
        if(!$this->validateURL($longURL))
            throw new \Exception("Invalid URL.");
        $this->longURL = $longURL;
    }

    public function setShortCode(string $str){
        $this->shortCode = $str;
    }

    public function validateURL($longURL): bool{
        return filter_var($longURL, FILTER_VALIDATE_URL) ? true: false;
    }

    private function generateShortCode(): string{
        $randStr = str_shuffle($this->acceptedChars);
        return substr($randStr, 0, 15);
    }

    public static function hasShortCode(string $str): bool{
        $db = Database::getDatabase();
        $sql = "SELECT short_code FROM url WHERE short_code = ?";
        $res = $db->fetch($sql, [$str]);
        if(count($res) !== 0)
            return true;
        return false;
    }

    public static function add($url): bool{
        $sql = "INSERT INTO url (long_url, short_code) VALUES (?, ?)";
        $args = [$url->longURL, $url->shortCode];
        $db = Database::getDatabase();

        return $db->query($sql, $args);
    }

    public static function getLongURLFromShortCode(string $str): ?string{
        $sql = "SELECT long_url FROM url WHERE short_code = ?";
        $args = [$str];
        $db = Database::getDatabase();

        $res = $db->fetch($sql, $args);
        if(count($res) > 0)
            return $res[0]['long_url'];
        return false;
    }

    public static function createUniqueShortCode(URL $urlObj): string{
        $str = $urlObj->generateShortCode();
        while(URL::hasShortCode($str)){
            $str = $urlObj->generateShortCode();
        }
        return $str;
    }
}