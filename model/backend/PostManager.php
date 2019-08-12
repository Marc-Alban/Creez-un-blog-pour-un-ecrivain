<?php
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

        $req = $this->dbConnect()->query("
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
            WHERE posts.id = " . $id
        );

        $result = $req->fetchAll(PDO::FETCH_ASSOC);
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
    public function edit(string $title, string $content, bool $posted, int $id)
    {
        $e = [
            'title' => $title,
            'content' => $content,
            'posted' => $posted,
            'id' => $id,
        ];

        $sql = "UPDATE posts SET title = :title, content = :content, date_posts = NOW(), posted = :posted WHERE id = :id ";
        $req = $this->dbConnect()->prepare($sql);
        $req->execute($e);

        header("Location: index.php?page=post&id=" . $id);
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
    public function post($title, $content, $name, $posted, $tmp_name, $extention)
    {

        $req = $this->dbConnect()->query('SELECT MAX(id) FROM posts ORDER BY id DESC');
        $res = $req->fetch();
        $id = $res[0];

        if (!$tmp_name) {
            $id = "post";
            $extention = ".png";
        } else {
            move_uploaded_file($tmp_name, "../img/post/" . $id . $extention);
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
        header("Location: index.php?page=post&id=" . $this->dbConnect()->lastInsertId());
    }

    /**
     * Affiche la liste des post de la bdd, ainsi que ceux non publié
     *
     */
    public function getPosts()
    {

        $req = $this->dbConnect()->query("
    SELECT *
    FROM posts
    ORDER BY date_posts
    DESC
    ");

        $results = array();

        while ($rows = $req->fetchObject()) {
            $results[] = $rows;
        }

        return $results;
    }
}