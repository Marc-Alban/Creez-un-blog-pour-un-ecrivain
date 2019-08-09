<?php

use Openclassroom\Blog\Model\CommentsManager;
use Openclassroom\Blog\Model\PostManager;

require 'model/CommentsManager.php';
require 'model/PostManager.php';

/**
 * Renvoie les commentaires sur la page post
 */
function getComment(int $id): void
{
    $commentManager = new CommentsManager;
    require 'view/frontend/postView.php';
    $responses = $commentManager->get_comments($id);
}

/**
 * Insert les commentaires en BDD
 */
function comment($name, $comment, $id)
{
    $commentManager = new CommentsManager;

    $responses = $commentManager->comment($name, $comment, $id);
}

/**
 * Renvoie la page erreur
 */
function getError()
{
    ob_start();
    require 'view/frontend/error.php';
    $error = ob_get_clean();
    require 'view/frontend/template.php';

}

/**
 * Renvoie les posts sur la page Accueil
 */
function getFooter()
{
    ob_start();
    require 'view/frontend/footerView.php';
    $footer = ob_get_clean();
    require 'view/frontend/template.php';

}

/**
 * Renvoie les posts sur la page Accueil
 */
function getHeader()
{
    ob_start();
    require 'view/frontend/headerView.php';
    $header = ob_get_clean();
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
    require 'view/frontend/homeView.php';
    $content = ob_get_clean();
    require 'view/frontend/template.php';
}

/**
 * Renvoie le post sur la page post
 */
function getPost(int $id): void
{
    $postManager = new PostManager;
    $post = $postManager->get_post($id);
    ob_start();
    require 'view/frontend/postView.php';
    $content = ob_get_contents();
    require 'view/frontend/template.php';
}

/**
 * Renvoie les posts sur la page chapitres
 */
function listPosts()
{
    $postManager = new PostManager;
    $posts = $postManager->getPosts();
    require 'view/frontend/chapitreView.php';
}

/**
 *Signalement -- Commentaire
 */

function signalComment($id, $admin)
{
    $commentManager = new CommentsManager;
    $commentManager->alertComment($id, $admin);
}