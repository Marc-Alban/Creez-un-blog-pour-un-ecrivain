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
$actionTab = ['signalComment', 'submit', 'connexion', 'valide', 'remove', 'newChapter', 'modified', 'deleted'];

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
} else if (in_array($action, $actionTab) && $id >= 0) {

} else {
    $controller->$methode();
}