<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model;

use \PDO;

class Manager extends PDO
{

    private static $_instance = null;
    const DSN = 'mysql:host=localhost;dbname=blog';
    const USER = 'root';
    const PASSWORD = '';

    private function __construct()
    {
        try {
            $db = parent::__construct(self::DSN, self::USER, self::PASSWORD);
            return $db;
        } catch (Exception $e) {
            die('Erreur:' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new static;
        }
        return (self::$_instance);
    }

}