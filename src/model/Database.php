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

    /**
     * Connexion à la bdd si ce n'est pas déjà fait
     *
     * @return PDO
     */
    public static function getDb(): PDO
    {
        if (self::$db == null) {
            $bdd = new PDO(self::DSN, self::USER, self::PASSWORD);
            self::$db = $bdd;
            return $bdd;
        } else {
            self::$db;
        }
    }
}