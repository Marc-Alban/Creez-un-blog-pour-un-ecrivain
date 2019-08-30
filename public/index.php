<?php
declare (strict_types = 1);
//Démarage session
session_start();
//Récupère l'autoload
require '../vendor/autoload.php';
// Demande les différents controllers
use Blog\Controller\BackendController;
use Blog\Controller\FrontendController;

//Instance de l'objet
$frontController = new FrontendController;
$backController = new BackendController;

if (isset($_GET['page']) || !empty($_GET['page'])) {
    if ($_GET['page'] == 'home') {
        var_dump($bdd);
        die();
        $frontController->homeAction();
    } else if ($_GET['page'] == 'chapters') {
        $frontController->chaptersAction();
    } else if ($_GET['page'] == 'chapter') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            if (isset($_GET['action']) && $_GET['action'] == 'signalComment') {
                $frontController->signalAction((int) $_GET['idComment'], (int) $_GET['id']);
            }
            if (isset($_GET['action']) && $_GET['action'] == 'submit') {
                $frontController->sendCommentAction($_POST, (int) $_GET['id']);
            }
            $frontController->chapterAction((int) $_GET['id']);
        }
    } else if ($_GET['page'] == 'login') {
        if (isset($_GET['action']) && $_GET['action'] == 'connexion') {
            $backController->connexionAction($_SESSION, $_POST);
        }
        $backController->loginAction($_GET);
    } else if ($_GET['page'] == 'logout') {
        $backController->logoutAction();
    } else if ($_GET['page'] == 'admin') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            if (isset($_GET['action'])) {
                if ($_GET['action'] == 'valide') {
                    $backController->valideCommentAction((int) $_GET['id']);
                }
                if ($_GET['action'] == 'remove') {
                    $backController->removeCommentAction((int) $_GET['id']);
                }
            }
        }
        $backController->adminAction();
    } else if ($_GET['page'] == 'adminChapters') {
        $backController->chaptersAction();
    } else if ($_GET['page'] == 'write') {
        if (isset($_GET['action']) && $_GET['action'] == 'newChapter') {
            $backController->writeFormAction($_POST, $_FILES);
        }
        $backController->writeAction();
    } else if ($_GET['page'] == 'adminEdit') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            if (isset($_GET['action']) && $_GET['action'] == 'modified') {
                $backController->editAction((int) $_GET['id'], $_POST, $_FILES);
            }
            if (isset($_GET['action']) && $_GET['action'] == 'deleted') {
                $backController->deleteAction((int) $_GET['id']);
            }
            $backController->updateAction((int) $_GET['id']);
        } else {
            $backController->chaptersAction();
        }
    } else if ($_GET['page'] == 'error') {
        $frontController->errorAction();
    }
} else {
    $frontController->homeAction();
}