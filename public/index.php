<?php
declare (strict_types = 1);
//Démarage session
session_start();
//Récupère l'autoload
require '../vendor/autoload.php';

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;
$page = $_GET['page'] ?? 'home';
$pageFront = ['home','chapters','chapter','error'];
$pageBack = ['login','logout','admin','adminChapters','write','adminEdit'];
$actionTab = ['signalComment','submit','connexion','valide','remove','newChapter','modified','deleted'];




if(in_array($page, $pageFront)){
    $controllerName = 'Blog\Controller\FrontendController';
    // $frontController = new FrontendController();
    // $method = $page.'Action';
    // $frontController->$method();
} else if(in_array($page, $pageBack)){
    $controllerName = 'Blog\Controller\BackendController';
    // $backController = new BackendController;
    // $method = $page.'Action';
    // $backController->$method();
}

$controller = new $controllerName();
$methode = $page.'Action';
$controller->$methode((int) $id);
if(in_array($action, $actionTab)){
        $methodeAction = $action.'Action';
        $controller->$methodeAction((int) $id);
    }




// if(empty($page)){
    //     FrontendControllerhomeAction();
    // }


    // if ($_GET['page'] == 'home') {
    //     FrontendController::homeAction();
    // } else if ($_GET['page'] == 'chapters') {
    //     FrontendController::chaptersAction();
    // } else if ($_GET['page'] == 'chapter') {
    //     if (isset($_GET['id']) && $_GET['id'] > 0) {
    //         if (isset($_GET['action']) && $_GET['action'] == 'signalComment') {
    //             FrontendController::signalAction((int) $_GET['idComment'], (int) $_GET['id']);
    //         }
    //         if (isset($_GET['action']) && $_GET['action'] == 'submit') {
    //             FrontendController::sendCommentAction($_POST, (int) $_GET['id']);
    //         }
    //         FrontendController::chapterAction((int) $_GET['id']);
    //     }
    // } else if ($_GET['page'] == 'login') {
    //     if (isset($_GET['action']) && $_GET['action'] == 'connexion') {
    //         BackendController::connexionAction($_SESSION, $_POST);
    //     }
    //     BackendController::loginAction($_GET);
    // } else if ($_GET['page'] == 'logout') {
    //     BackendController::logoutAction();
    // } else if ($_GET['page'] == 'admin') {
    //     if (isset($_GET['id']) && $_GET['id'] > 0) {
    //         if (isset($_GET['action'])) {
    //             if ($_GET['action'] == 'valide') {
    //                 BackendController::valideCommentAction((int) $_GET['id']);
    //             }
    //             if ($_GET['action'] == 'remove') {
    //                 BackendController::removeCommentAction((int) $_GET['id']);
    //             }
    //         }
    //     }
    //     BackendController::adminAction();
    // } else if ($_GET['page'] == 'adminChapters') {
    //     BackendController::chaptersAction();
    // } else if ($_GET['page'] == 'write') {
    //     if (isset($_GET['action']) && $_GET['action'] == 'newChapter') {
    //         BackendController::writeFormAction($_POST, $_FILES);
    //     }
    //     BackendController::writeAction();
    // } else if ($_GET['page'] == 'adminEdit') {
    //     if (isset($_GET['id']) && $_GET['id'] > 0) {
    //         if (isset($_GET['action']) && $_GET['action'] == 'modified') {
    //             BackendController::editAction((int) $_GET['id'], $_POST, $_FILES);
    //         }
    //         if (isset($_GET['action']) && $_GET['action'] == 'deleted') {
    //             BackendController::deleteAction((int) $_GET['id']);
    //         }
    //         BackendController::updateAction((int) $_GET['id']);
    //     } else {
    //         BackendController::chaptersAction();
    //     }
    // } else if ($_GET['page'] == 'error') {
    //     FrontendController::errorAction();
    // }
