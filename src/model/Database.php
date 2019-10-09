<?php
declare (strict_types = 1);
namespace Blog\Model;

use \PDO;

class Database
{
    // const DSN = 'mysql:host=localhost;dbname=dbs185636';
    // const USER = 'dbu94874';
    // const PASSWORD = 'adminTest123.';
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
        if (self::$db === null) {
            self::$db = new PDO(self::DSN, self::USER, self::PASSWORD);
        }
        return self::$db;
    }
}