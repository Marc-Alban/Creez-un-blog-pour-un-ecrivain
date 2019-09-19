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
$pageBack = ['login', 'logout', 'admin', 'adminChapters', 'write', 'adminEdit'];
$actionTab = ['submitComment', 'connexion', 'newChapter', 'modified', 'deleted', 'signalComment', 'valideComment', 'removeComment'];

if (in_array($page, $pageFront)) {
    $controllerName = 'Blog\Controller\FrontendController';
} else if (in_array($page, $pageBack)) {
    $controllerName = 'Blog\Controller\BackendController';
} else {
    $controllerName = 'Blog\Controller\FrontendController';
}

$controller = new $controllerName();
$methode = $page . 'Action';
$actionMethode = $action . 'Action';

if (in_array($page, $pageFront) || in_array($page, $pageBack)) {
    if ($action === null && $id === null) {
        $controller->$methode(['session' => $_SESSION]);
    } else if ($action !== null && $id !== null) {
        if (in_array($action, $actionTab)) {
            $controller->$actionMethode(['post' => $_POST, 'get' => $_GET, 'files' => $_FILES, 'session' => $_SESSION]);
            $controller->$methode($_GET);
        }
    } else if ($action !== null || $id === null) {
        if (in_array($action, $actionTab)) {
            $controller->$actionMethode($_POST);
            $controller->$methode(['session' => $_SESSION]);
        }
    } else if ($action === null || $id !== null) {
        $controller->$methode($_GET, ['session' => $_SESSION]);
    }
} else {
    $controller->errorAction();
}