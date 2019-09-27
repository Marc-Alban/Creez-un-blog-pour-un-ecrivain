<?php
declare (strict_types = 1);
namespace Blog\Model\Backend;

use Blog\Model\Database;
use \PDO;

class CommentManager
{
/**
 * Affiche les commentaires écrit dans le front sur le dashboard
 *
 * @return array
 */
    public function getComments(): array
    {

        $query = Database::getDb()->query("
    SELECT  comments.id,
            comments.name,
            comments.date_comment,
            comments.post_id,
            comments.comment,
            posts.title
    FROM    comments
    JOIN    posts
    ON      comments.post_id = posts.id
    WHERE   comments.seen = '1'
    ORDER BY comments.date_comment ASC
    ");
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    /**
     *Nombre de commentaire dans
     *
     * @param integer $id
     * @return void
     */
    public function chapterComment(int $id)
    {
        $query = Database::getDb()->prepare("
        SELECT  comments.id,
                comments.name,
                comments.date_comment,
                comments.post_id,
                comments.comment,
                posts.title
        FROM    comments
        JOIN    posts
        ON      comments.post_id = posts.id
        WHERE   comments.seen = '1'
        AND 	comments.post_id = :id
        ORDER BY comments.date_comment ASC
        ");
        $query->execute([':id' => $id]);
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

/**
 * Permet de supprimer un commentaire en bdd
 *
 * @param integer $id
 * @return void
 */
    public function deleteComments(int $id): void
    {
        $query = Database::getDb()->prepare("DELETE FROM comments WHERE id = :id");
        $query->execute(["id" => $id]);
    }

/**
 * Permet de valider le commentaire et de le remettre à la valeur 0 dans la table seen
 *
 * @param integer $id
 * @return void
 */
    public function validateComments(int $id): void
    {
        $query = Database::getDb()->prepare("UPDATE comments SET seen = '0' WHERE id = :id");
        $query->execute(["id" => $id]);
    }

    /**
     * Nombre de commentaire tableau
     *
     * @return void
     */
    public function nbComments()
    {
        $query = Database::getDb()->query("SELECT post_id, COUNT(seen) as seen FROM comments WHERE seen = '1' GROUP BY post_id");
        $result = $query->fetchAll();
        return $result;
    }

}