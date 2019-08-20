<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model;

use \PDO;

class Manager
{

    private $dbHost;
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $pdo;

    public function __construct($dbName = 'blog', $dbHost = 'localhost', $dbUser = 'root', $dbPassword = '')
    {
        $this->dbHost = $dbHost;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
    }

    public function getPDO()
    {
        if (is_null($this->pdo)) {
            unset($this->pdo);
            $pdo = new PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }
}