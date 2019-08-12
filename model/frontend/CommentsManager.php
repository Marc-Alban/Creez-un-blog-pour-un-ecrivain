<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model\Frontend;

use Openclassroom\Blog\Model\Manager;
use \PDO;

require_once 'model/Manager.php';

class CommentsManager extends Manager
{
    /**
     * Renvoie les commentaires sur la page post
     *
     * @return
     */
    public function get_comments(int $id)
    {
        $query = $this->dbConnect()->prepare("
                                                SELECT *
                                                FROM comments
                                                WHERE post_id = :id
                                                ORDER BY date_comment
                                                DESC
                                            ");
        $query->execute(['id' => $id]);
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    /**
     * Insert le commentaire de la page post en bdd
     *
     * @return string
     */
    public function setComment(string $name, string $comment, int $post_id)
    {
        $comment = array(
            'name' => $name,
            'comment' => $comment,
            'post_id' => $post_id,
        );

        $sql = "
                INSERT INTO comments(name, comment, post_id, date_comment)
                VALUES(:name, :comment, :post_id, NOW())
              ";
        $req = $this->dbConnect()->prepare($sql);
        $req->execute($comment);
    }

    /**
     * Signalement Commentaire
     */

    public function alertComment(int $id, $admin): ?int
    {
        if (isset($id) && isset($admin)) {
            $query = $this->dbConnect()->prepare("UPDATE comments SET seen = '1' WHERE id = :id");
            $query->execute(['id' => $id]);
            header('Location: index.php?page=home');
        }
    }

}