<?php
declare (strict_types = 1);
namespace Blog\Model;

use \PDO;

class Database
{
    const DSN = 'mysql:host=localhost;dbname=blog';
    const USER = 'root';
    const PASSWORD = '';
    private static $db = null;

    public static function getDb(): PDO
    {
        if (self::$db == null) {
            $db = new PDO(self::DSN, self::USER, self::PASSWORD);
            return $db;
        } else {
            self::$db;
        }
    }
}