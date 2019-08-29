<?php
declare (strict_types = 1);
namespace Blog\Model\Frontend;

use Blog\Model\Database;
use \PDO;

class CommentsDatabase
{
/**
 * Renvoie les commentaires sur la page post
 *
 * @param integer $id
 * @return void
 */
    public function getComments(int $id)
    {
        $sql = "
        SELECT *
        FROM comments
        WHERE post_id = :id
        ORDER BY date_comment
        DESC
        ";
        $query = Database::getDb()->prepare($sql);
        $query->execute(['id' => $id]);
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    /**
     * Insert le commentaire de la page post en bdd
     *
     * @param string $name
     * @param string $comment
     * @param integer $post_id
     * @return void
     */
    public function setComment(string $name, string $comment, int $post_id)
    {
        $sql = "
        INSERT INTO comments(name, comment, post_id, date_comment)
        VALUES(:name, :comment, :post_id, NOW())
        ";
        $comment = array(
            'name' => $name,
            'comment' => $comment,
            'post_id' => $post_id,
        );
        $req = Database::getDb()->prepare($sql);
        $req->execute($comment);
    }

/**
 * Signalement Commentaire en bdd
 *
 * @param integer $commentid
 * @return void
 */
    public function signalComment(int $comment_id)
    {
        $sql = "
            UPDATE comments
            SET seen = '1' WHERE id = :id
            ";

        $query = Database::getDb()->prepare($sql);
        $query->execute(['id' => $comment_id]);
    }

}