<?php

use Openclassroom\Blog\Model\backend\DashboardManager;

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