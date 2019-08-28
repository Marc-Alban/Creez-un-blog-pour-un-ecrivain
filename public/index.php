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
if (isset($_GET['page'])) {
    if ($_GET['page'] == 'home') {
        $frontController->homeAction();
    } else if ($_GET['page'] == 'chapters') {
        $frontController->chaptersAction();
    } else if ($_GET['page'] == 'chapter') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            if (isset($_GET['action']) && $_GET['action'] == 'signalComment') {
                if (isset($_GET['idComment'])) {
                    $frontController->signalAction($_GET['idComment'], $_GET['id']);
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == 'submit') {
                $frontController->sendCommentAction($_POST, $_GET['id']);
            }
            $frontController->chapterAction($_GET['id']);
        } else {
            throw new Exception('Aucun identifiant envoyé !');
        }
    } else if ($_GET['page'] == 'login') {
        if (!isset($_SESSION['password'])) {
            if (isset($_GET['action']) && $_GET['action'] == 'connexion') {
                $backController->connexionAction($_SESSION, $_POST);
            }
            $backController->loginAction($_GET);
        } else {
            $backController->adminAction();
        }
    } else if ($_GET['page'] == 'logout') {
        $backController->logoutAction();
    } else if ($_GET['page'] == 'admin') {
        if (isset($_SESSION['password'])) {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (isset($_GET['action'])) {
                    if ($_GET['action'] == 'valide') {
                        $backController->valideCommentAction($_GET['id']);
                    }
                    if ($_GET['action'] == 'remove') {
                        $backController->removeCommentAction($_GET['id']);
                    }
                }
            }
            $backController->adminAction();
        } else {
            $backController->loginAction($_GET);
        }
    } else if ($_GET['page'] == 'adminChapters') {
        if (isset($_SESSION['password'])) {
            $backController->chaptersAction();
        } else {
            $backController->loginAction($_GET);
        }
    } else if ($_GET['page'] == 'write') {
        if (isset($_SESSION['password'])) {
            if (isset($_GET['action']) && $_GET['action'] == 'newChapter') {
                $backController->writeFormAction($_POST, $_FILES);
            }
            $backController->writeAction();
        } else {
            $backController->loginAction($_GET);
        }
    } else if ($_GET['page'] == 'adminEdit') {
        if (isset($_SESSION['password'])) {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (isset($_GET['action']) && $_GET['action'] == 'modified') {

                    if (isset($_FILES)) {
                        if (!empty($_FILES['image']['name'])) {

                            $backController->editImageAction($_GET['id'], $_POST, $_FILES);
                        }
                    }
                    $backController->editAction($_GET['id'], $_POST);
                }
                if (isset($_GET['action']) && $_GET['action'] == 'deleted') {
                    $backController->deleteAction($_GET['id']);
                }
                $backController->updateAction($_GET['id']);
            } else {
                $backController->chaptersAction();
            }
        } else {
            $backController->loginAction($_GET);
        }
    }

} else {
    $frontController->errorAction();
}