<?php
declare (strict_types = 1);
use Openclassroom\Blog\Model\Backend\CommentManager;
use Openclassroom\Blog\Model\backend\DashboardManager;
use Openclassroom\Blog\Model\Backend\PostManager;

require 'model/backend/CommentsManager.php';
require 'model/backend/DashboardManager.php';
require 'model/backend/PostManager.php';

/**
 * Retourne la page home du dashboard
 */
function getDashboard()
{
    $commentManager = new CommentManager;
    $comments = $commentManager->get_comment();
    ob_start();
    require 'view/backend/headerView.php';
    require 'view/backend/dashboardView.php';
    $content = ob_get_clean();
    require 'view/backend/template.php';
    return $comments;
}

/**
 * Validation du commentaire
 *et renvoie sur la page destinaire
 * @param int $id
 */
function validateComment(int $id)
{
    $commentManager = new CommentManager;
    $commentManager->valComment($id);
}

/**
 *Supression du commentaire
 *et renvoie sur la page destinaire
 *
 * @param integer $id
 */
function deleteComment(int $id)
{
    $commentManager = new CommentManager;
    $commentManager->delComments($id);
}

/**
 * Récupère la liste des chapitres
 * publié ou pas
 */
function getList()
{
    $postManager = new PostManager;
    $posts = $postManager->getPosts();

    ob_start();
    require 'view/backend/headerView.php';
    require 'view/backend/listView.php';
    $content = ob_get_clean();
    require 'view/backend/template.php';
}

/**
 * Permet de récupérer un post
 * et de l'éditer
 * @param integer $id
 */
function getPostEdit(int $id)
{
    $postManager = new PostManager;
    $post = $postManager->get_post($id);
    ob_start();
    require 'view/backend/headerView.php';
    require 'view/backend/postView.php';
    $content = ob_get_clean();
    require 'view/backend/template.php';
}

/**
 * Fonction pour mettre à jour
 *
 * @param integer $id
 * @param string $title
 * @param string $content
 * @param string $tmp_name
 * @param string $extention
 * @param integer $posted
 * @return void
 */
function updatePost(int $id, string $title, string $content, string $tmp_name, string $extention, int $posted)
{
    $postManager = new PostManager;
    $postManager->edit($id, $title, $content, $tmp_name, $extention, $posted);

}

/**
 * Permet de suprimer un post
 *
 * @param integer $id
 * @return void
 */
function PostDelete(int $id)
{
    $postManager = new PostManager;
    $postManager->deletePost($id);
}

/**
 * Récupère la page pour écrire un post
 */
function getWrite()
{
    ob_start();
    require 'view/backend/headerView.php';
    require 'view/backend/writeView.php';
    $content = ob_get_clean();
    require 'view/backend/template.php';
}

/**
 * Fonction qui écrit en bdd un post
 *
 * @param string $title
 * @param string $content
 * @param string $name
 * @param integer $posted
 * @param string $tmp_name
 * @param string $extention
 */
function PostWrite(string $title, string $content, string $name, int $posted, string $tmp_name, string $extention)
{
    $postManager = new PostManager;
    $post = $postManager->postWrite($title, $content, $name, $posted, $tmp_name, $extention);
}

/**
 * Renvoie la page login sur le dashboard
 */
function getLogin()
{
    ob_start();
    require 'view/backend/loginView.php';
    $content = ob_get_clean();
    require 'view/backend/template.php';
}

/**
 * Fonction qui permet de récuperer le mot de passe de l'admin
 */
function getUser()
{
    $dashboardManager = new DashboardManager;
    $pass = $dashboardManager->isAdmin();
    return $pass;
}

/**
 * Permet la déconnexion de l'utilisateur
 * Supprime la session en court
 *
 *  */
function logOut()
{
    $dashboardManager = new DashboardManager;
    $dashboardManager->logoutUser();

}