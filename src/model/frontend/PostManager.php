<?php
declare (strict_types = 1);
namespace Blog\Model\Frontend;

use Blog\Model\Database;
use \PDO;

class PostDatabase
{
/**
 * Renvoie le chapitre sur la page post
 * avec une jointure sur la table admin
 * pour connaitre l'auteur
 *
 * @param integer $id
 * @return array
 */
    public function getChapter(int $id): array
    {
        $sql = "
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
        ";

        $query = Database::getDb()->prepare($sql);
        $query->execute([':id' => $id]);
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

/**
 * Renvoie les différents chapitres (limit - 2) sur la page Accueil
 * avec une jointure sur la table admin
 * pour connaitre l'auteur
 *
 * @return array
 */
    public function getLimitedChapters(): array
    {
        $sql = "
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
        ";

        $query = Database::getDb()->query($sql);
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    /**
     * Renvoie les différents chapitres sur la page Chapitre
     * quand le champs posted en bdd est à 1
     *
     * @return array
     */
    public function getChapters(): array
    {
        $sql = "
        SELECT *
        FROM posts
        WHERE posted='1'
        ORDER BY date_posts
        ASC
        ";
        $query = Database::getDb()->query($sql);
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }
}