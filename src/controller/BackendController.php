<?php
declare (strict_types = 1);
namespace Blog\Controller;

use Blog\Model\Backend\CommentManager;
use Blog\Model\Backend\DashboardManager;
use Blog\Model\Backend\PostManager;
use Blog\View\View;

class BackendController
{
/**
 * Retourne la page commentaire
 *
 * @param array $session
 * @return void
 */
    public function adminCommentsAction(array &$session, array $getData): void
    {
        if (isset($session['user'])) {

            $commentManager = new CommentManager();
            $action = $getData['get']['action'] ?? null;
            if (isset($action)) {
                $id = (int) $getData['get']['id'];
                if ($action === 'valideComment') {
                    $commentManager->validateComments($id);
                } else if ($action === 'removeComment') {
                    $commentManager->deleteComments($id);
                }
            }
            $comments = $commentManager->getComments();
            $view = new View();
            $view->getView('backend', 'adminCommentsView', ['comments' => $comments, 'title' => 'Dashboard', 'session' => $session]);

        } else {
            header('Location: index.php?page=login&action=connexion');
        }

    }

/**
 * Récupère la liste des chapitres sur le Backend
 *
 * @param array $session
 * @return void
 */
    public function adminChaptersAction(array &$session, array $getData): void
    {
        if (isset($session['user'])) {
            $action = $getData['get']['action'] ?? null;
            $postManager = new PostManager();

            if ($action === 'delete') {
                $postManager->deleteChapter((int) $getData['get']['id']);
            }

            $dashboardManager = new DashboardManager;
            if ($action === "logout") {
                $dashboardManager->logoutUser();
                header('Location: index.php?page=login&action=connexion');

            }

            $chapters = $postManager->getChapters();
            $commentManager = new CommentManager();
            $nbComments = $commentManager->nbComments();
            $view = new View();
            $view->getView('backend', 'chaptersView', ['chapters' => $chapters, 'title' => 'Listes chapitres', 'session' => $session, 'nbComments' => $nbComments]);
        } else {
            header('Location: index.php?page=login&action=connexion');
        }
    }

/**
 * Permet de récupérer un chapitre
 * Modifie un chapitre
 * @param array $getData
 * @param array $session
 * @return void
 */
    public function adminChapterAction(array &$session, array $getData): void
    {
        if (isset($session['user'])) {

            $postManager = new PostManager();

            $id = (int) $getData['get']['id'];
            $action = $getData['get']['action'] ?? null;
            $errors = $session['errors'] ?? null;
            unset($session['errors']);

            if ($action === "adminEdit") {
                $title = $getData['post']['title'] ?? null;
                $content = $getData['post']['content'] ?? null;
                $file = $getData['files']['image']['name'] ?? null;
                $tmpName = $getData['files']['image']['tmp_name'] ?? null;
                $posted = (isset($getData['post']['public']) && $getData['post']['public'] == 'on') ? 1 : 0;
                $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
                $extention = strrchr($file, '.');
                if (!empty($title) || !empty($content)) {
                    if (!empty($title)) {
                        if (!empty($content)) {
                            $postManager->editChapter($id, $title, $content, $posted);
                            if (isset($file) && !empty($file)) {
                                if (in_array($extention, $extentions) || $extention = ".png") {
                                    $postManager->editImageChapter($id, $title, $content, $tmpName, $extention, $posted);
                                } else {
                                    $errors['valide'] = 'Image n\'est pas valide! ';
                                }
                            }
                        } else {
                            $errors['emptyContent'] = 'Mettre un contenu ';
                        }
                    } else {
                        $errors['emptyTitle'] = 'Mettre un Titre ';
                    }
                } else {
                    $errors['ChampsVide'] = 'Veuillez remplir tous les champs !';
                }
            }
            $chapter = $postManager->getChapter($id);
            $view = new View();
            $view->getView('backend', 'chapterView', ['chapter' => $chapter, 'title' => 'Chapitre', 'errors' => $errors, 'session' => $session]);
        } else {
            header('Location: index.php?page=login&action=connexion');
        }
    }

/**
 * Récupère la page pour écrire un post
 *
 * @param array $session
 * @return void
 */
    public function adminWriteAction(array &$session, array $getData): void
    {
        if (isset($session['user'])) {

            $postManager = new PostManager();
            $action = $getData['get']['action'] ?? null;
            $errors = (isset($session['errors'])) ? $session['errors'] : null;
            unset($session['errors']);

            if ($action === 'newChapter') {

                $title = $getData['post']['title'] ?? null;
                $description = $getData['post']['description'] ?? null;
                $posted = (isset($getData['post']['public']) && $getData['post']['public'] == 1) ? 1 : 0;
                $file = $getData['files']['image']['name'] ?? null;
                $tmpName = $getData['files']['image']['tmp_name'] ?? null;
                $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
                $name = $postManager->getName();
                $extention = strrchr($file, '.');

                if (!empty($title) && !empty($description)) {
                    if (!empty($title)) {
                        if (!empty($description)) {
                            if (!empty($tmpName)) {
                                if (in_array($extention, $extentions)) {
                                    $postManager->chapterWrite($title, $description, $name["name_post"], $posted, $tmpName, $extention);
                                    header('Location: index.php?page=adminChapters');
                                } else {
                                    $errors['image'] = 'Image n\'est pas valide! ';
                                }
                            } else {
                                $errors['imageVide'] = 'Image obligatoire pour un chapitre ! ';
                            }
                        } else {
                            $errors['emptyDesc'] = "Veuillez mettre un paragraphe";
                        }
                    } else {
                        $errors['emptyTitle'] = "Veuillez mettre un titre";
                    }
                } else {
                    $errors['contenu'] = 'Veuillez renseigner un contenu !';
                }
            }
            $view = new View();
            $view->getView('backend', 'writeView', ['title' => 'Ecrire un chapitre', 'errors' => $errors, 'session' => $session]);
        } else {
            header('Location: index.php?page=login&action=connexion');
        }
    }

/**
 * Renvoie la page login
 *
 * @param [type] $session
 * @return void
 */
    public function loginAction(&$session, array $getData): void
    {
        $dashboardManager = new DashboardManager();
        $action = $getData['get']['action'] ?? null;
        $errors = (isset($session['errors'])) ? $session['errors'] : null;
        unset($session['errors']);
        if ($action === "connexion") {
            $passwordBdd = $dashboardManager->getPass();
            $password = $getData["post"]['password'] ?? null;
            if (isset($getData['post']['connexion'])) {
                if (!empty($password)) {
                    if (password_verify($password, $passwordBdd)) {
                        $session['user'] = $password;
                        header('Location: index.php?page=adminChapters');
                    } else {
                        $errors['Password'] = 'Ce mot de passe n\'est pas bon pas !';
                    }
                } else {
                    $errors["Champs"] = 'Champs vide !';
                }
            }
        }
        $view = new View();
        $view->getView('backend', 'loginView', ['title' => 'Connexion', 'errors' => $errors, 'session' => $session]);
    }

    /**
     * Renvoie la page erreur
     *
     * @param [type] $session
     * @return void
     */
    public function errorAction(): void
    {
        $view = new View();
        $view->getView('backend', 'errorView', null);
    }

}