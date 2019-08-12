<?php

use Openclassroom\Blog\Model\backend\DashboardManager;
use Openclassroom\Blog\Model\Backend\PostManager;

require 'model/backend/CommentsManager.php';
require 'model/backend/PostManager.php';
require 'model/backend/DashboardManager.php';

/**
 * Retourne la page home du dashboard
 */
function getDashboard()
{
    ob_start();
    require 'view/backend/headerView.php';
    require 'view/backend/dashboardView.php';
    $content = ob_get_clean();
    require 'view/backend/template.php';
}

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

function getPostEdit($id)
{
    $postManager = new PostManager;
    $post = $postManager->get_post($id);
    ob_start();
    require 'view/backend/headerView.php';
    require 'view/backend/postView.php';
    $content = ob_get_clean();
    require 'view/backend/template.php';
}

function updatePost($title, $content, $posted, $id)
{
    $postManager = new PostManager;
    $postManager->edit($title, $content, $posted, $id);
    header('Location: index.php?page=list');
}

function getWrite()
{
    ob_start();
    require 'view/backend/headerView.php';
    require 'view/backend/writeView.php';
    $content = ob_get_clean();
    require 'view/backend/template.php';
}

function PostWrite($title, $content, $name, $posted, $tmp_name, $extention)
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

function getUser()
{
    $dashboardManager = new DashboardManager;
    $pass = $dashboardManager->isAdmin();
    return $pass;
}