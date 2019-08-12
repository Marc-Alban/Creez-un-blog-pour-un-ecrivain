<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model\Frontend;

use Openclassroom\Blog\Model\Manager;
use \PDO;

require_once 'model/Manager.php';

class PostManager extends Manager
{
    /**
     * Renvoie le chapitre sur la page post
     * avec une jointure sur la table admin
     * pour connaitre l'auteur
     *
     * @return object
     */
    public function get_post(int $id): ?object
    {
        $query = $this->dbConnect()->prepare("
            SELECT  posts.id,
                    posts.title,
                    posts.content,
                    posts.image_posts,
                    posts.date_posts,
                    admins.name
            FROM    posts
            JOIN    admins
            ON      name_post = admins.name
            WHERE   posts.id = :id
            AND     posts.posted = '1'
            ");
        $query->execute(['id' => $id]);
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * Renvoie les différents chapitres sur la page Accueil
     * avec une jointure sur la table admin
     * pour connaitre l'auteur
     * et limitation de deux derniers chapitres sur la page
     *
     * @return array
     */
    public function get_posts(): ?array
    {
        $query = $this->dbConnect()->query("
        SELECT  posts.id,
                posts.title,
                posts.image_posts,
                posts.date_posts,
                posts.content,
                admins.name
        FROM posts
        JOIN admins
        ON posts.name_post=admins.name
        WHERE posted='1'
        ORDER BY date_posts DESC
        LIMIT 0,2
        ");
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    /**
     * Renvoie les différents chapitres sur la page Chapitre
     * quand le champs posted en bdd est à 1
     *
     * @return object
     */
    public function getPosts(): ?array
    {

        $query = $this->dbConnect()->query("
        SELECT *
        FROM posts
        WHERE posted='1'
        ORDER BY date_posts
        ASC
        ");

        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }
}