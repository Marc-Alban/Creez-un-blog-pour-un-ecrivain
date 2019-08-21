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
        } else {
            throw new Exception('Aucun identifiant envoyé !');
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
    } else if ($_GET['page'] == 'adminChapters') {
        if (isset($_SESSION['password'])) {
            $backController->chaptersAction();
        } else {
            header('Location: index.php?page=login');
        }
    } else if ($_GET['page'] == 'write') {
        if (isset($_SESSION['password'])) {
            if (isset($_POST['newChapter'])) {
                $backController->writeFormAction();
            }
            $backController->writeAction();
        } else {
            header('Location: index.php?page=login');
        }
    } else if ($_GET['page'] == 'adminEdit') {
        if (isset($_SESSION['password'])) {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $id = intval($_GET['id']);
                $title = (isset($_POST['title'])) ? $_POST['title'] : '';
                $content = (isset($_POST['content'])) ? $_POST['content'] : '';
                $posted = (isset($_POST['public']) == 'on') ? 1 : 0;
                if (isset($_POST['modified'])) {
                    if (isset($_FILES)) {
                        if (!empty($_FILES['image']['name'])) {
                            $file = $_FILES['image']['name'];
                            $tmp_name = $_FILES['image']['tmp_name'];
                            $backController->editImageAction($id, $title, $content, $tmp_name, $posted, $file);
                        }
                    }

                    $backController->editAction($id, $title, $content, $posted);
                    //header('Location: index.php?page=adminEdit');
                }

                if (isset($_POST['deleted'])) {
                    $backController->deleteAction($id);
                    header('Location: index.php?page=adminEdit');
                }

                $backController->updateAction($id);

            } else {
                $backController->chaptersAction();
            }

        } else {
            header('Location: index.php?page=login');
        }
    }

} else {
    $frontController->errorAction();
}