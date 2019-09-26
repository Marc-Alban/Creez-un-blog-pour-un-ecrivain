<?php
declare (strict_types = 1);
namespace Blog\Model\Backend;

use Blog\Model\Database;
use \PDO;

class PostManager
{

/**
 * Renvoie le chapitre sur la page post en bdd
 *
 * @param integer $id
 * @return void
 */
    public function getChapter(int $id): array
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

        $query = Database::getDb()->prepare($sql);
        $query->execute([":id" => $id]);
        $req = $query->fetchAll(PDO::FETCH_OBJ);
        return $req;
    }

/**
 * Affiche la liste des post de la bdd, ainsi que ceux non publié
 *
 * @return array
 */
    public function getChapters(): array
    {
        $sql = "
        SELECT *
        FROM posts
        ORDER BY date_posts
        DESC
        ";
        $query = Database::getDb()->query($sql);
        $req = $query->fetchAll(PDO::FETCH_OBJ);
        return $req;
    }

/**
 * Retourne le nom de l'auteur
 *
 * @return array
 */
    public function getName(): array
    {
        $sql = "SELECT name_post FROM posts ";
        $query = Database::getDb()->query($sql);
        $req = $query->fetch();
        return $req;
    }

    /**
     * Met à jour le chapitre modifié en BDD
     *
     * @param integer $id
     * @param string $title
     * @param string $content
     * @param string $tmpName
     * @param string $extention
     * @param integer $posted
     * @return void
     */
    public function editImageChapter(int $id, string $title, string $content, string $tmpName, string $extention, int $posted): void
    {
        $sql_id = "
        SELECT id
        FROM posts
        WHERE id = :id
        ";

        $req = Database::getDb()->prepare($sql_id);
        $req->execute([':id' => $id]);
        $response = $req->fetch(PDO::FETCH_ASSOC);
        $id = $response['id'];

        if (!$tmpName) {
            $id = "post";
            $extention = ".png";
        } else {
            move_uploaded_file($tmpName, "img/chapter/" . $id . $extention);
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

        $query = Database::getDb()->prepare($sql);
        $query->execute($e);
    }

    /**
     * Permet d'éditer un chapitre en back office
     *
     * @param integer $id
     * @param string $title
     * @param string $content
     * @param integer $posted
     * @return void
     */
    public function editChapter(int $id, string $title, string $content, int $posted): void
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
            posted = :posted
        WHERE id = :id ";

        $query = Database::getDb()->prepare($sql);
        $query->execute($e);
    }

    /**
     * Suprime le poste en bdd
     *
     * @param integer $id
     * @return void
     */
    public function deleteChapter(int $id): void
    {
        $sql = "
        DELETE FROM posts
        WHERE id = :id
        ";

        $query = Database::getDb()->prepare($sql);
        $query->execute(['id' => $id]);
    }

/**
 * Insert en bdd un nouveau post en bdd
 *
 * @param string $title
 * @param string $content
 * @param string $name
 * @param integer $posted
 * @param string $tmpName
 * @param string $extention
 * @return void
 */
    public function chapterWrite(string $title, string $description, string $name, int $posted, string $tmpName, string $extention): void
    {
        $sql_id = "
        SELECT MAX(id)
        FROM posts
        ORDER BY id
        DESC
        ";

        $req = Database::getDb()->query($sql_id);
        $response = $req->fetch();
        $id = $response[0];

        if (!$tmpName) {
            $id = "post";
            $extention = ".png";
        } else {
            move_uploaded_file($tmpName, "img/chapter/" . $id . $extention);
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

        $query = Database::getDb()->prepare($sql);
        $query->execute($p);
    }

}