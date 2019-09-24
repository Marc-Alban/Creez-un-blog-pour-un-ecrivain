<?php
declare (strict_types = 1);
//Démarage session
session_start();
//Récupère l'autoload
require '../vendor/autoload.php';
$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;
$page = $_GET['page'] ?? 'home';
$pageFront = ['home', 'chapters', 'chapter'];
$pageBack = ['adminComments', 'adminChapters', 'adminChapter', 'adminWrite', 'login'];

if (in_array($page, $pageFront)) {
    $controllerName = 'Blog\Controller\FrontendController';
} else if (in_array($page, $pageBack)) {
    $controllerName = 'Blog\Controller\BackendController';
}

$controller = new $controllerName();
$methode = $page . 'Action';

if (in_array($page, $pageFront) || in_array($page, $pageBack)) {
    if ($action === null && $id === null) {
        $controller->$methode($_SESSION);
    } else if ($action !== null && $id !== null) {
        $controller->$methode(['post' => $_POST, 'get' => $_GET, 'files' => $_FILES], $_SESSION);
    } else if ($action !== null && $id === null) {
        $controller->$methode(['post' => $_POST, 'files' => $_FILES], $_SESSION);
    } else if ($action === null || $id !== null) {
        $controller->$methode(['get' => $_GET, 'post' => $_POST], $_SESSION);
    }
}

$controller->errorAction();