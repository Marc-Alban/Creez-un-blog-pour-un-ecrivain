<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model;

use \PDO;

class Manager
{

    protected $dbName;
    protected $dbUser;
    protected $dbPass;
    protected $dbHost;
    protected $pdo;

    public function __construct($dbName = 'blog', $dbUser = 'root', $dbPass = '', $dbHost = 'localhost')
    {
        var_dump('****************************Coco***********************');
        $this->$dbName = $dbName;
        $this->$dbUser = $dbUser;
        $this->$dbPass = $dbPass;
        $this->$dbHost = $dbHost;
    }

    protected function getPDO()
    {

        if ($this->pdo === null) {
            $pdo = new PDO('mysql:dbname=blog;host=localhost', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }
}