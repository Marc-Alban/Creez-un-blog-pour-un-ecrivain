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
 * Retourne la page home du dashboard
 *
 * @param array $session
 * @return void
 */
    public function adminAction(array &$session): void
    {
        $commentManager = new CommentManager();
        $comments = $commentManager->getComments();
        if (isset($session['user'])) {
            $view = new View();
            $view->getView('backend', 'dashboardView', ['comments' => $comments, 'title' => 'Dashboard', 'session' => $session]);
        } else {
            header('Location: index.php?page=login&action=connexion');
        }
    }
/**
 * Valide un commentaire
 *
 * @param array $getData
 * @return void
 */
    public function valideCommentAction(array $getData): void
    {
        $commentManager = new CommentManager();
        $commentManager->validateComments((int) $getData['get']['id']);
    }
/**
 * Supprime un commentaire
 *
 * @param array $getData
 * @return void
 */
    public function removeCommentAction(array $getData): void
    {
        $commentManager = new CommentManager();
        $commentManager->deleteComments((int) $getData['get']['id']);
    }
/**
 * Récupère la liste des chapitres sur le dashboard
 *
 * @param array $session
 * @return void
 */
    public function adminChaptersAction(array &$session): void
    {
        $postManager = new PostManager();
        $chapters = $postManager->getChapters();
        if (isset($session['user'])) {
            $view = new View();
            $view->getView('backend', 'chaptersView', ['chapters' => $chapters, 'title' => 'Listes chapitres', 'session' => $session]);
        } else {
            header('Location: index.php?page=login&action=connexion');
        }
    }
/**
 * Permet de récupérer un chapitre
 *
 * @param array $getData
 * @param array $session
 * @return void
 */
    public function adminChapterAction(array $getData, array &$session): void
    {
        $postManager = new PostManager();
        $chapter = $postManager->getChapter((int) $getData['id']);
        if (isset($session['user'])) {
            $errors = (isset($session['errors'])) ? $session['errors'] : null;
            unset($session['errors']);
            $view = new View();
            $view->getView('backend', 'chapterView', ['chapter' => $chapter, 'title' => 'Chapitre', 'errors' => $errors, 'session' => $session]);
        } else {
            header('Location: index.php?page=login&action=connexion');
        }
    }
/**
 * Modifie un chapitre
 *
 * @param array $getData
 * @return void
 */
    public function adminEditAction(array $getData): void
    {
        $postManager = new PostManager();
        $title = (isset($getData['post']['title'])) ? $getData['post']['title'] : null;
        $content = (isset($getData['post']['content'])) ? $getData['post']['content'] : null;
        $posted = (isset($getData['post']['public']) && $getData['post']['public'] == 'on') ? 1 : 0;
        $file = (isset($getData['files']['image']['name'])) ? $getData['files']['image']['name'] : null;
        $tmpName = (isset($getData['files']['image']['tmp_name'])) ? $getData['files']['image']['tmp_name'] : null;
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        if (!empty($title) || !empty($content)) {
            $postManager->editChapter((int) $getData['get']['id'], $title, $content, $posted);
            if (isset($file) && !empty($file)) {
                if (in_array($extention, $extentions) || $extention = ".png") {
                    $postManager->editImageChapter((int) $getData['get']['id'], $title, $content, $tmpName, $extention, $posted);
                } else {
                    $session['errors']['valide'] = 'Image n\'est pas valide! ';
                }
            }
        } else {
            $session['errors']['ChampsVide'] = 'Veuillez remplir tous les champs !';
        }
    }
/**
 * Suprime un chapitre
 *
 * @param array $getData
 * @return void
 */
    public function deleteAction(array $getData): void
    {
        $postManager = new PostManager();
        $postManager->deleteChapter((int) $getData['get']['id']);
        header('Location: index.php?page=adminChapters');
    }
/**
 * Récupère la page pour écrire un post
 *
 * @param array $session
 * @return void
 */
    public function adminWriteAction(array &$session): void
    {
        if (isset($session['user'])) {
            $errors = (isset($session['errors'])) ? $session['errors'] : null;
            unset($session['errors']);
            $view = new View();
            $view->getView('backend', 'writeView', ['title' => 'Ecrire un chapitre', 'errors' => $errors, 'session' => $session]);
        } else {
            header('Location: index.php?page=login&action=connexion');
        }
    }
/**
 * Permet d'écrire un nouveau chapitre
 *
 * @param array $getData
 * @param array $session
 * @return void
 */
    public function newChapterAction(array $getData, array &$session): void
    {
        $postManager = new PostManager();
        $title = (isset($getData['post']['title'])) ? $getData['post']['title'] : null;
        $description = (isset($getData['post']['description'])) ? $getData['post']['description'] : null;
        $posted = (isset($getData['post']['public']) && $getData['post']['public'] == 1) ? 1 : 0;
        $file = (isset($getData['files']['image']['name'])) ? $getData['files']['image']['name'] : null;
        $tmpName = (isset($getData['files']['image']['tmp_name'])) ? $getData['files']['image']['tmp_name'] : null;
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        $name = 'Jean Forteroche';
        if (!empty($title) && !empty($description)) {
            if (!empty($tmpName)) {
                if (in_array($extention, $extentions)) {
                    $postManager->chapterWrite($title, $description, $name, $posted, $tmpName, $extention);
                    header('Location: index.php?page=adminChapters');
                } else {
                    $session['errors']['image'] = 'Image n\'est pas valide! ';
                }
            } else {
                $session['errors']['imageVide'] = 'Image obligatoire pour un chapitre ! ';
            }
        } else {
            $session['errors']['contenu'] = 'Veuillez renseigner un contenu !';
        }
    }
/**
 * Renvoie la page login
 *
 * @param [type] $session
 * @return void
 */
    public function loginAction(&$session): void
    {
        if (!isset($session['user'])) {
            $errors = (isset($session['errors'])) ? $session['errors'] : null;
            unset($session['errors']);
            $view = new View();
            $view->getView('backend', 'loginView', ['title' => 'Connexion', 'errors' => $errors, 'session' => $session]);
        } else {
            header('Location: index.php?page=admin');
        }
    }
/**
 * Permet de se connecter
 *
 * @param array $getData
 * @param [type] $session
 * @return void
 */
    public function connexionAction(array $getData, &$session): void
    {
        $dashboardManager = new DashboardManager();
        $passwordBdd = $dashboardManager->getPass();
        $password = $getData["post"]['password'] ?? null;
        if (isset($getData['post']['connexion'])) {
            if (!empty($password)) {
                if (password_verify($password, $passwordBdd)) {
                    $session['user'] = $password;
                    header("Location: index.php?page=admin");
                } else {
                    $session['errors']['Password'] = 'Ce mot de passe n\'est pas bon pas !';
                }
            } else {
                $session['errors']["Champs"] = 'Champs vide !';
            }
        }
    }
/**
 * Permet de se déconnecter
 *
 * @return void
 */
    public function logoutAction(): void
    {
        $dashboardManager = new DashboardManager();
        $dashboardManager->logoutUser();
        header('Location:index.php?page=home');
    }
}