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
$pageBack = ['adminComments', 'adminChapters', 'adminChapter', 'adminWrite', 'login', 'adminProfil'];

if (in_array($page, $pageFront) || empty($page) || !in_array($page, $pageBack)) {
    $controllerName = 'Blog\Controller\FrontendController';
} else if (in_array($page, $pageBack)) {
    $controllerName = 'Blog\Controller\BackendController';
}

$controller = new $controllerName();
$methode = $page . 'Action';

if (in_array($page, $pageFront) || in_array($page, $pageBack)) {
    if (($action === null && $id === null) || ($action !== null && $id !== null || $action !== null && $id === null)) {
        $controller->$methode($_SESSION, ['get' => $_GET, 'post' => $_POST, 'files' => $_FILES]);
    } else if ($action === null && $id !== null) {
        $controller->$methode($_SESSION, ['post' => $_POST, 'get' => $_GET]);
    }
}
$controller->errorAction();