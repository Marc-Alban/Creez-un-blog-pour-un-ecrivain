<?php
use Openclassroom\Blog\Model\Manager;

class CommentManager extends Manager
{
    /**
     * Affiche les commentaires écrit dans le front
     *
     * @return void
     */
    public function get_comment()
    {

        $query = $this->dbConnect()->query("
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
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function deleteComments(int $id)
    {
        $query = $this->dbConnect()->prepare("DELETE FROM comments WHERE id = :id");
        $query->execute(["id" => $id]);
        header('Location: index.php?page=dashboard');
    }

    public function seeComment(int $id)
    {
        $query = $this->dbConnect()->exec("UPDATE comments SET seen = '0' WHERE id = :id");
        $query->execute(["id" => $id]);
        header('Location: index.php?page=dashboard');
    }
}