<?php
namespace Openclassroom\Blog\Model;

require_once 'model/Manager.php';

class CommentsManager extends Manager
{
    /**
     * Renvoie les commentaires sur la page post
     *
     * @return array
     */
    public function get_comments()
    {
        $req = $this->dbConnect()->query("SELECT * FROM comments WHERE post_id = '{$_GET['id']}' ORDER BY date_comment DESC");
        $results = [];

        while ($row = $req->fetchObject()) {
            $results[] = $row;
        }

        return $results;

    }

    /**
     * Insert le commentaire de la page post en bdd
     *
     * @return string
     */
    public function comment($name, $comment)
    {
        $comment = array(
            'name' => $name,
            'comment' => $comment,
            'post_id' => $_GET['id'],
        );

        $sql = "INSERT INTO comments(name, comment, post_id, date_comment) VALUES(:name, :comment, :post_id, NOW())";
        $req = $this->dbConnect()->prepare($sql);
        $req->execute($comment);
    }

}