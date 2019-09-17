<?php
declare (strict_types = 1);
//Démarage session
session_start();
//Récupère l'autoload
require '../vendor/autoload.php';

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;
$page = $_GET['page'] ?? 'home';
$pageFront = ['home', 'chapters', 'chapter', 'error'];
$pageBack = ['login', 'logout', 'admin', 'adminChapters', 'write', 'adminEdit'];
$actionPost = ['submit', 'connexion', 'newChapter', 'modified', 'deleted'];
$actionGet = ['signalComment', 'valide', 'remove'];

if (in_array($page, $pageFront)) {
    $controllerName = 'Blog\Controller\FrontendController';
    // $frontController = new FrontendController();
    // $method = $page.'Action';
    // $frontController->$method();
} else if (in_array($page, $pageBack)) {
    $controllerName = 'Blog\Controller\BackendController';
    // $backController = new BackendController;
    // $method = $page.'Action';
    // $backController->$method();
}

$controller = new $controllerName();
$methode = $page . 'Action';

if ($id >= 0) {
    $controller->$methode((int) $id);
    if ($action) {
        if (in_array($action, $actionPost)) {
            $controller->$methode((int) $id, $_POST);
        } else if (in_array($action, $actionGet)) {
            $controller->$methode((int) $id, $_GET);
        }
    }
} else {
    $controller->$methode();
}