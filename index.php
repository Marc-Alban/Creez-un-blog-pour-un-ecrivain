<?php
declare (strict_types = 1);
//Démarage session
session_start();
// Demande les différents controllers
require_once 'controller/FrontendController.php';
require_once 'controller/BackendController.php';
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
            $id = intval($_GET['id']);
            if (isset($_GET['action']) && $_GET['action'] == 'signalComment') {
                $comment_id = (isset($_GET['comment_id'])) ? intval($_GET['comment_id']) : '';
                $frontController->signalAction($comment_id);
                header('Location: index.php?page=chapter&id=' . $id);
            }

            if (isset($_POST['submit'])) {
                $frontController->sendCommentAction($_POST['name'], $_POST['comment'], $id);
            }

            $frontController->chapterAction($id);
        }
    } else if ($_GET['page'] == 'login') {
        if (!isset($_SESSION['password'])) {
            if (isset($_POST['connexion'])) {
                $password = intval($_POST['password']);
                $backController->connexionAction($password);
                $_SESSION['password'] = $backController->connexionAction($password);
            }
            $backController->loginAction();
        } else {
            header('Location: index.php?page=admin');
        }
    } else if ($_GET['page'] == 'admin') {
        if (isset($_SESSION['password'])) {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $id = intval($_GET['id']);
                if (isset($_GET['action'])) {
                    if ($_GET['action'] == 'valide') {
                        $backController->valideCommentAction($id);
                    }
                    if ($_GET['action'] == 'remove') {
                        $backController->removeCommentAction($id);
                    }
                }
            }
            $backController->adminAction();
        } else {
            header('Location: index.php?page=login');
        }
    } else if ($_GET['page'] == 'write') {
        if (isset($_SESSION['password'])) {
            if ($_POST['newChapter']) {
                $frontController->writeFormAction();
            }
            $frontController->writeAction();
        } else {
            header('Location: index.php?page=login');
        }
    } else if ($_GET['page'] == 'edit') {
        if (isset($_SESSION['password'])) {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $id = $_GET['id'];
                if ($_POST['edited']) {
                    $frontController->editFormAction($id);
                }
                if ($_POST['deleted']) {
                    $frontController->deleteFormAction($id);
                }
                $frontController->editAction($id);
            }
        } else {
            header('Location: index.php?page=login');
        }
    }

} else {
    $frontController->errorAction();
}