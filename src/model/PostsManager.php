<?php
declare (strict_types = 1);
namespace Blog\Model;

use Blog\Model\Database;
use \PDO;

class PostsManager
{

/**
 * Renvoie le chapitre
 *
 * @param integer $id
 * @return void
 */
    public function getChapter(int $id, int $order): array
    {
        if ($order === 1) {
            $sql1 = "
            SELECT  *
            FROM    posts
            WHERE   id = :id
            ";
            $query = Database::getDb()->prepare($sql1);
        } else if ($order === 2) {
            $sql2 = "
            SELECT  posts.id,
                    posts.title,
                    posts.content,
                    posts.image_posts,
                    posts.date_posts,
                    admins.name
            FROM    posts
            JOIN    admins
            WHERE   posts.id = :id
            AND     posts.posted = '1'
            ";
            $query = Database::getDb()->prepare($sql2);
        }

        $query->execute([":id" => $id]);
        $req = $query->fetchAll(PDO::FETCH_OBJ);
        return $req;
    }

/**
 * Affiche la liste des post de la bdd, ainsi que ceux non publié
 *
 * @return array
 */
    public function getChapters(int $order): array
    {
        if ($order === 1) {
            $sql1 = "
            SELECT *
            FROM posts
            WHERE posted='1'
            ORDER BY date_posts
            ASC
            ";
            $query = Database::getDb()->query($sql1);
        } else if ($order === 2) {
            $sql2 = "
            SELECT *
            FROM posts
            ORDER BY date_posts
            DESC
            ";
            $query = Database::getDb()->query($sql2);
        }

        $req = $query->fetchAll(PDO::FETCH_OBJ);
        return $req;
    }

    /**
     * Renvoie le dernier chapitre sur la page Accueil
     *
     * @return array
     */
    public function getLimitedChapters(): array
    {
        $sql = "
    SELECT  posts.id,
            posts.title,
            posts.image_posts,
            posts.date_posts,
            posts.content,
            admins.name
    FROM posts
    JOIN admins
    WHERE posted='1'
    ORDER BY date_posts DESC
    LIMIT 0,1
    ";

        $query = Database::getDb()->query($sql);
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    /**
     * Retourne le premier chapitre sur la page d'accueil
     *
     * @return array
     */
    public function oldLimitedChapter(): array
    {
        $sql = "
        SELECT  posts.id,
                posts.title,
                posts.image_posts,
                posts.date_posts,
                posts.content,
                admins.name
        FROM posts
        JOIN admins
        WHERE posts.id=1
        ";

        $query = Database::getDb()->query($sql);
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $results;
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
     * Met à jour le chapitre modifié
     * en BDD avec une image
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
     *sans image
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
 * Insert un nouveau chapitre en bdd
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
        if (!$tmpName) {
            $id = "post";
            $extention = ".png";
        }

        $query = Database::getDb()->query('SELECT MAX(id) FROM posts ORDER BY date_posts = NOW()');
        $response = $query->fetch();
        $id = $response['MAX(id)'] + 1;

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

        move_uploaded_file($tmpName, "img/chapter/" . $id . $extention);

    }

}