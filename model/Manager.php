<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model;

use \PDO;

class Manager
{

    private $dbhost = 'localhost';
    private $dbname = 'blog';
    private $dbuser = 'root';
    private $dbpass = '';

    /**
     * Connexion à la BDD
     *
     * @return void
     */
    protected function dbConnect()
    {
        var_dump('*************************************Coucou******************************************');
        try
        {
            $bdd = new PDO('mysql:host=' . $this->dbhost . ';dbname=' . $this->dbname . ';charset=utf8', $this->dbuser, $this->dbpass);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            return $bdd;
        } catch (PDOexception $e) {
            die('Une erreur est survenu lors de la connexion à la bas de donnée !');
        }
    }
}