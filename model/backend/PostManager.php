<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model\Backend;

use Openclassroom\Blog\Model\Manager;
use \PDO;

require_once 'model/Manager.php';

class PostManager extends Manager
{

/**
 * Renvoie le chapitre sur la page post en bdd
 *
 * @param integer $id
 * @return void
 */
    public function get_post(int $id)
    {
        $sql = "
        SELECT  title,
                content,
                image_posts,
                date_posts,
                posted
        FROM    posts
        WHERE   id = :id
        ";

        $query = $this->dbConnect()->prepare($sql);
        $query->execute([":id" => $id]);
        $req = $query->fetchAll(PDO::FETCH_OBJ);
        return $req;
    }

    /**
     * Met à jour le poste modifié en BDD
     *
     * @param integer $id
     * @param string $title
     * @param string $content
     * @param string $tmp_name
     * @param string $extention
     * @param integer $posted
     * @return void
     */
    public function edit(int $id, string $title, string $content, string $tmp_name, string $extention, int $posted)
    {
        $sql_id = "
        SELECT id
        FROM posts
        WHERE id = :id
        ";

        $req = $this->dbConnect()->prepare($sql_id);
        $req->execute([':id' => $id]);
        $response = $req->fetch(PDO::FETCH_ASSOC);
        $id = $response['id'];

        if (!$tmp_name) {
            $id = "post";
            $extention = ".png";
        } else {
            move_uploaded_file($tmp_name, "public/img/post/" . $id . $extention);
        }

        $e = [
            ':id' => $id,
            ':title' => $title,
            ':content' => $content,
            ':image_posts' => $id . $extention,
            ':posted' => $posted,
        ];

        $sql = "
        UPDATE posts
        SET title = :title,
            content = :content,
            image_posts = :image_posts,
            date_posts = NOW(),
            posted = :posted
        WHERE id = :id ";

        $query = $this->dbConnect()->prepare($sql);
        $query->execute($e);
    }

    /**
     * Suprime le poste en bdd
     *
     * @param integer $id
     * @return void
     */
    public function deletePost(int $id)
    {
        $sql = "
        DELETE FROM posts
        WHERE id = :id
        ";

        $query = $this->dbConnect()->prepare($sql);
        $query->execute(['id' => $id]);
        header("Location: index.php?page=list");
    }

/**
 * Insert en bdd un nouveau post en bdd
 *
 * @param string $title
 * @param string $content
 * @param string $name
 * @param integer $posted
 * @param string $tmp_name
 * @param string $extention
 * @return void
 */
    public function postWrite(string $title, string $content, string $name, int $posted, string $tmp_name, string $extention)
    {
        $sql_id = "
        SELECT MAX(id)
        FROM posts
        ORDER BY id
        DESC
        ";

        $req = $this->dbConnect()->query($sql_id);
        $response = $req->fetch();
        $id = $response[0];

        if (!$tmp_name) {
            $id = "post";
            $extention = ".png";
        } else {
            move_uploaded_file($tmp_name, "public/img/post/" . $id . $extention);
        }

        $p = [
            'title' => $title,
            'content' => $content,
            'name_post' => $name,
            'image_posts' => $id . $extention,
            'posted' => $posted,
        ];

        $sql = "
    INSERT INTO posts(title, content, name_post, image_posts, date_posts, posted)
    VALUES(:title, :content, :name_post, :image_posts, NOW(), :posted)
    ";

        $query = $this->dbConnect()->prepare($sql);
        $query->execute($p);
        header("Location: index.php?page=list");
    }

    /**
     * Affiche la liste des post de la bdd, ainsi que ceux non publié
     *
     * @return void
     */
    public function getPosts()
    {
        $sql = "
        SELECT *
        FROM posts
        ORDER BY date_posts
        DESC
        ";
        $query = $this->dbConnect()->query($sql);
        $req = $query->fetchAll(PDO::FETCH_OBJ);
        return $req;
    }
}