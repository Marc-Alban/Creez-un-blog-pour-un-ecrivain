<?php

use Openclassroom\Blog\Model\Frontend\CommentsManager;
use Openclassroom\Blog\Model\Frontend\PostManager;

require 'model/frontend/CommentsManager.php';
require 'model/frontend/PostManager.php';

/**
 * Renvoie les commentaires sur la page post et le post
 *
 * @param integer $id
 */
function requireView(int $id)
{
    $commentManager = new CommentsManager;
    $responses = $commentManager->get_comments($id);

    $postManager = new PostManager;
    $post = $postManager->get_post($id);

    ob_start();
    require 'view/frontend/headerView.php';
    require 'view/frontend/postView.php';
    require 'view/frontend/footerView.php';
    $content = ob_get_clean();
    require 'view/frontend/template.php';

}

/**
 * Insert les commentaires en BDD
 *
 * @param string $name
 * @param string $comment
 * @param integer $id
 */
function instComment(string $name, string $comment, int $id)
{
    $commentManager = new CommentsManager;
    $commentManager->setComment($name, $comment, $id);
}

/**
 * Renvoie la page erreur
 */
function getError()
{
    ob_start();
    require 'view/frontend/headerView.php';
    require 'view/frontend/errorView.php';
    $content = ob_get_clean();
    require 'view/frontend/template.php';

}

/**
 * Renvoie les posts sur la page Accueil
 * et le contenu
 */
function getHome()
{
    $postManager = new PostManager;
    $posts = $postManager->get_posts();
    ob_start();
    require 'view/frontend/headerView.php';
    require 'view/frontend/homeView.php';
    require 'view/frontend/footerView.php';
    $content = ob_get_clean();
    require 'view/frontend/template.php';
}

/**
 * Renvoie les posts sur la page chapitres
 */
function listPosts()
{
    $postManager = new PostManager;
    $posts = $postManager->getPosts();
    ob_start();
    require 'view/frontend/headerView.php';
    require 'view/frontend/chapitreView.php';
    require 'view/frontend/footerView.php';
    $content = ob_get_clean();
    require 'view/frontend/template.php';
}

/**
 * Signalement -- Commentaire
 *
 * @param integer $commentid
 */
function signalComment(int $commentid)
{
    $commentManager = new CommentsManager;
    $commentManager->alertComment($commentid);
}