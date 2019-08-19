<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model\Backend;

use Openclassroom\Blog\Model\Manager;
use \PDO;

require_once 'model/Manager.php';

class CommentManager extends Manager
{
    /**
     * Affiche les commentaires écrit dans le front sur le dashboard
     *
     * @return void
     */
    public function getComments()
    {

        $query = $this->getPDO()->query("
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
 * Permet de supprimer un commentaire en bdd
 *
 * @param integer $id
 * @return void
 */
    public function deleteComments(int $id = null)
    {
        $query = $this->getPDO()->prepare("DELETE FROM comments WHERE id = :id");
        $query->execute(["id" => $id]);

    }

    /**
     * Permet de valider le commentaire et de le remettre à la valeur 0 dans la table seen
     *
     * @param integer $id
     * @return void
     */
    public function validateComments(int $id = null)
    {
        $query = $this->getPDO()->prepare("UPDATE comments SET seen = '0' WHERE id = :id");
        $query->execute(["id" => $id]);
    }
}