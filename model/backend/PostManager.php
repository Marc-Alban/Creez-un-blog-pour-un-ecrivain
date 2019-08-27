<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model\Backend;

use Openclassroom\Blog\Model\Manager;
use \PDO;

require_once 'model/Manager.php';

class PostManager 
{

/**
 * Renvoie le chapitre sur la page post en bdd
 */
    public function getChapter(int $id)
    {
        $sql = "
        SELECT  id,
                title,
                content,
                image_posts,
                date_posts,
                posted
        FROM    posts
        WHERE   id = :id
        ";

        $query = Manager::getInstance()->prepare($sql);
        $query->execute([":id" => $id]);
        $req = $query->fetchAll(PDO::FETCH_OBJ);
        return $req;
    }

    /**
     * Affiche la liste des post de la bdd, ainsi que ceux non publié
     */
    public function getChapters()
    {
        $sql = "
        SELECT *
        FROM posts
        ORDER BY date_posts
        DESC
        ";
        $query = Manager::getInstance()->query($sql);
        $req = $query->fetchAll(PDO::FETCH_OBJ);
        return $req;
    }

    /**
     * Met à jour le chapitre modifié en BDD
     */
    public function editImageChapter(int $id, string $title, string $content, string $tmp_name, string $extention, int $posted)
    {
        $sql_id = "
        SELECT id
        FROM posts
        WHERE id = :id
        ";

        $req = Manager::getInstance()->prepare($sql_id);
        $req->execute([':id' => $id]);
        $response = $req->fetch(PDO::FETCH_ASSOC);
        $id = $response['id'];

        if (!$tmp_name) {
            $id = "post";
            $extention = ".png";
        } else {
            move_uploaded_file($tmp_name, "public/img/chapter/" . $id . $extention);
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

        $query = Manager::getInstance()->prepare($sql);
        $query->execute($e);
    }

    public function editChapter(int $id, string $title, string $content, int $posted)
    {
        $e = [
            ':id' => $id,
            ':title' => $title,
            ':content' => $content,
            ':posted' => $posted,
        ];

        $sql = "
        UPDATE posts
        SET title = :title,
            content = :content,
            date_posts = NOW(),
            posted = :posted
        WHERE id = :id ";

        $query = Manager::getInstance()->prepare($sql);
        $query->execute($e);
    }

    /**
     * Suprime le poste en bdd
     *
     * @param integer $id
     * @return void
     */
    public function deleteChapter(int $id)
    {
        $sql = "
        DELETE FROM posts
        WHERE id = :id
        ";

        $query = Manager::getInstance()->prepare($sql);
        $query->execute(['id' => $id]);
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
    public function chapterWrite(string $title, string $description, string $name, int $posted, string $tmp_name, string $extention)
    {
        $sql_id = "
        SELECT MAX(id)
        FROM posts
        ORDER BY id
        DESC
        ";

        $req = Manager::getInstance()->query($sql_id);
        $response = $req->fetch();
        $id = $response[0];

        if (!$tmp_name) {
            $id = "post";
            $extention = ".png";
        } else {
            move_uploaded_file($tmp_name, "public/img/chapter/" . $id . $extention);
        }

        $p = [
            'title' => $title,
            'content' => $description,
            'name_post' => $name,
            'image_posts' => $id . $extention,
            'posted' => $posted,
        ];

        $sql = "
    INSERT INTO posts(title, content, name_post, image_posts, date_posts, posted)
    VALUES(:title, :content, :name_post, :image_posts, NOW(), :posted)
    ";

        $query = Manager::getInstance()->prepare($sql);
        $query->execute($p);
    }

}