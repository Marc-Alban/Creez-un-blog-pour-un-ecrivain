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
$pageBack = ['admin', 'adminChapters', 'adminChapter', 'adminWrite', 'login'];
$actionTab = ['submitComment', 'connexion', 'newChapter', 'adminEdit', 'modified', 'delete', 'signalComment', 'valideComment', 'removeComment', 'logout'];
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
        $controller->$methode($_SESSION);
    } else if ($action !== null && $id !== null) {
        if (in_array($action, $actionTab)) {
            $controller->$actionMethode(['post' => $_POST, 'get' => $_GET, 'files' => $_FILES]);
            $controller->$methode($_GET, $_SESSION);
        }
    } else if ($action !== null || $id === null) {
        if (in_array($action, $actionTab)) {
            $controller->$actionMethode(['post' => $_POST, 'files' => $_FILES], $_SESSION);
            $controller->$methode($_SESSION);
        }
    } else if ($action === null || $id !== null) {
        $controller->$methode($_GET, $_SESSION);
    }
} else {
    $controller->errorAction();
}