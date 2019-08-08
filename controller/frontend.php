<?php
declare (strict_types = 1);
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

    $responses = $commentManager->get_comments($id);
    require 'view/frontend/postView.php';
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
    require 'view/frontend/error.php';
}

/**
 * Renvoie les posts sur la page Accueil
 */
function getHome()
{
    $postManager = new PostManager;
    $posts = $postManager->get_posts();
    require 'view/frontend/homeView.php';
}

/**
 * Renvoie le post sur la page post
 */
function getPost(int $id): void
{
    $postManager = new PostManager;
    $post = $postManager->get_post($id);
    require 'view/frontend/postView.php';
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