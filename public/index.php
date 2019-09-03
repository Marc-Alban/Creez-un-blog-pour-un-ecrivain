<?php
declare (strict_types = 1);
//Démarage session
session_start();
//Récupère l'autoload
require '../vendor/autoload.php';

// Demande les différents controllers
use Blog\Controller\FrontendController;
use Blog\Controller\BackendController;

if (isset($_GET['page']) || !empty($_GET['page'])) {
    if ($_GET['page'] == 'home') {
        FrontendController::homeAction();
    } else if ($_GET['page'] == 'chapters') {
        $frontController->chaptersAction();
    } else if ($_GET['page'] == 'chapter') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            if (isset($_GET['action']) && $_GET['action'] == 'signalComment') {
                FrontendController::signalAction((int) $_GET['idComment'], (int) $_GET['id']);
            }
            if (isset($_GET['action']) && $_GET['action'] == 'submit') {
                FrontendController::sendCommentAction($_POST, (int) $_GET['id']);
            }
            FrontendController::chapterAction((int) $_GET['id']);
        }
    } else if ($_GET['page'] == 'login') {
        if (isset($_GET['action']) && $_GET['action'] == 'connexion') {
            BackendController::connexionAction($_SESSION, $_POST);
        }
        BackendController::loginAction($_GET);
    } else if ($_GET['page'] == 'logout') {
        BackendController::logoutAction();
    } else if ($_GET['page'] == 'admin') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            if (isset($_GET['action'])) {
                if ($_GET['action'] == 'valide') {
                    BackendController::valideCommentAction((int) $_GET['id']);
                }
                if ($_GET['action'] == 'remove') {
                    BackendController::removeCommentAction((int) $_GET['id']);
                }
            }
        }
        BackendController::adminAction();
    } else if ($_GET['page'] == 'adminChapters') {
        BackendController::chaptersAction();
    } else if ($_GET['page'] == 'write') {
        if (isset($_GET['action']) && $_GET['action'] == 'newChapter') {
            BackendController::writeFormAction($_POST, $_FILES);
        }
        BackendController::writeAction();
    } else if ($_GET['page'] == 'adminEdit') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            if (isset($_GET['action']) && $_GET['action'] == 'modified') {
                BackendController::editAction((int) $_GET['id'], $_POST, $_FILES);
            }
            if (isset($_GET['action']) && $_GET['action'] == 'deleted') {
                BackendController::deleteAction((int) $_GET['id']);
            }
            BackendController::updateAction((int) $_GET['id']);
        } else {
            BackendController::chaptersAction();
        }
    } else if ($_GET['page'] == 'error') {
        FrontendController::errorAction();
    }
} else {
    FrontendController::homeAction();
}