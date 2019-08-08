<?php

use Openclassroom\Blog\Model\CommentsManager;
use Openclassroom\Blog\Model\PostManager;

require 'model/CommentsManager.php';
require 'model/PostManager.php';

/**
 * Renvoie les commentaires sur la page post
 */
function getComment()
{
    $commentManager = new CommentsManager;
    $responses = $commentManager->get_comments();

    require 'view/frontend/postView.php';
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
 * Renvoie le header (menu)
 */
// function getHeader()
// {
//     require 'view/frontend/headerView.php';
// }

/**
 * Renvoie le post sur la page post
 */
function getPost()
{
    $postManager = new PostManager;
    $post = $postManager->get_post();
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