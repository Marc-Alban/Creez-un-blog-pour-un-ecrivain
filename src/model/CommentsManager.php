<?php
declare (strict_types = 1);
namespace Blog\Model;

use Blog\Model\Database;
use \PDO;

class CommentsManager
{
/**
 * Affiche les commentaires écrit dans le front sur le dashboard
 *
 * @return array
 */
    public function getComments(?int $id): array
    {
        $sql = null;
        if (isset($id)) {
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

        } elseif (!isset($id) && $id === null) {
            $sql = "
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
            ";
            $query = Database::getDb()->query($sql);
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            return $results;
        }
    }

    /**
     * Insert le commentaire de la page post en bdd
     *
     * @param string $name
     * @param string $comment
     * @param integer $post_id
     * @return void
     */
    public function setComment(string $name, string $comment, ?int $postId): void
    {
        $sql = "
        INSERT INTO comments(name, comment, post_id, date_comment)
        VALUES(:name, :comment, :postId, NOW())
        ";
        $commentArray = [
            ':name' => $name,
            ':comment' => $comment,
            ':postId' => $postId,
        ];
        $req = Database::getDb()->prepare($sql);
        $req->execute($commentArray);
    }

    /**
     * Signalement Commentaire en bdd
     *
     * @param integer $commentid
     * @return void
     */
    public function signalComment(?int $commentId): void
    {
        $sql = "
        UPDATE comments
        SET seen = '1' WHERE id = :id
        ";

        $query = Database::getDb()->prepare($sql);
        $query->execute(['id' => $commentId]);
    }

    /**
     *Nombre de commentaire sur un chapitre
     *
     * @param integer $id
     * @return void
     */
    public function chapterComment(?int $id): array
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
    public function deleteComments(?int $id): void
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
    public function validateComments(?int $id): void
    {
        $query = Database::getDb()->prepare("UPDATE comments SET seen = '0' WHERE id = :id");
        $query->execute(["id" => $id]);
    }

    /**
     * Nombre de commentaire tableau
     *
     * @return array
     */

    public function nbComments(): array
    {
        $query = Database::getDb()->query("SELECT post_id, COUNT(seen) as seen FROM comments WHERE seen = '1' GROUP BY post_id");
        $result = $query->fetchAll();

        $sortedResult = [];

        foreach ($result as $value) {

            $sortedResult[$value['post_id']] = $value['seen'];
        };

        return $sortedResult;
    }

}