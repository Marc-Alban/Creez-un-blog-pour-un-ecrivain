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
     * avec une jointure sur la table admin
     * pour connaitre l'auteur
     *
     * @param integer $id
     */
    public function get_post(int $id)
    {
        $sql = "
        SELECT  posts.id,
                posts.title,
                posts.image_posts,
                posts.date_posts,
                posts.content,
                posts.posted,
                admins.name
        FROM posts
        JOIN admins
        ON posts.name_post = admins.name
        WHERE posts.id = :id";

        $req = $this->dbConnect()->prepare($sql);
        $req->execute(['id' => $id]);
        $result = $req->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * Met à jour le poste modifié en BDD
     *
     * @param string $title
     * @param string $content
     * @param boolean $posted -> public ou non
     * @param integer $id
     */
    public function edit($tmp_name, $extention, string $title, string $content, int $posted, int $id)
    {

        $query = $this->dbConnect()->prepare('SELECT id FROM posts WHERE id = :id');
        $query->execute(['id' => $id]);
        $response = $query->fetch();
        $id = $response[0];

        if (!$tmp_name) {
            $id = "post";
            $extention = ".png";
        } else {
            move_uploaded_file($tmp_name, "public/img/post/" . $id . $extention);
        }

        $e = [
            'image_posts' => $id . $extention,
            'title' => $title,
            'content' => $content,
            'posted' => $posted,
            'id' => $id,
        ];

        $sql = "UPDATE posts SET image_posts = :image_posts,  title = :title, content = :content, date_posts = NOW(), posted = :posted WHERE id = :id ";
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
        $sql = "DELETE FROM posts WHERE id = " . $id;
        $this->dbConnect()->exec($sql);
        header("Location: index.php?page=list");
    }

    /**
     * Insert en bdd un nouveau post en bdd
     *
     * @param [type] $title
     * @param [type] $content
     * @param [type] $name
     * @param [type] $posted
     * @param [type] $tmp_name
     * @param [type] $extention
     */
    public function postWrite($title, $content, $name, $posted, $tmp_name, $extention)
    {

        $query = $this->dbConnect()->query('SELECT MAX(id) FROM posts ORDER BY id DESC');
        $response = $query->fetch();
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

        $req = $this->dbConnect()->prepare($sql);
        $req->execute($p);
        header("Location: index.php?page=list");
    }

    /**
     * Affiche la liste des post de la bdd, ainsi que ceux non publié
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
        $query->fetch(PDO::FETCH_OBJ);
        return $query;
    }
}