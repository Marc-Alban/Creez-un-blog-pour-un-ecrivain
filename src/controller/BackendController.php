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
 * @return void
 */
    public function adminAction(array $session): void
    {
        $commentManager = new CommentManager();
        $comments = $commentManager->getComments();
        // if (isset($getData['session'])) {
        $view = new View();
        $view->getView('backend', 'dashboardView', ['comments' => $comments, 'title' => 'Dashboard']);
        // } else {
        //     header('Location: index.php?page=login&action=connexion');
        // }
    }

    /**
     * Valide un commentaire
     *
     * @param integer $id
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
     * @param integer $id
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
 * @return void
 */
    public function adminChaptersAction(array $session): void
    {

        $postManager = new PostManager();
        $chapters = $postManager->getChapters();
        // var_dump($getData);
        // die();
        // if (!empty($getData['session'])) {
        $view = new View();
        $view->getView('backend', 'chaptersView', ['chapters' => $chapters, 'title' => 'Listes chapitres']);
        // } else {
        //     header('Location: index.php?page=login&action=connexion');
        // }
    }

/**
 * Permet de récupérer un chapitre
 *
 * @param integer $id
 * @return void
 */
    public function adminChapterAction(array $getData): void
    {
        $postManager = new PostManager();
        $chapter = $postManager->getChapter((int) $getData['id']);
        // var_dump($getData);
        // die();
        // if (!empty($getData['session'])) {
        $view = new View();
        $view->getView('backend', 'chapterView', ['chapter' => $chapter, 'title' => 'Chapitre']);
        // } else {
        //     header('Location: index.php?page=login&action=connexion');
        // }
    }

    /**
     * Modifie un chapitre
     *
     * @param integer $id
     * @param array $post
     * @param array $files
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
                    $errors['valide'] = 'Image n\'est pas valide! ';
                }
            }
        } else {
            $errors['ChampsVide'] = 'Veuillez remplir tous les champs !';
        }

    }

    /**
     * Suprime un chapitre
     *
     * @param integer $id
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
 * @return void
 */
    public function adminWriteAction(array $session): void
    {
        // var_dump($session);
        // die();
        // if (!empty($getData['session'])) {
        $view = new View();
        $view->getView('backend', 'writeView', ['title' => 'Ecrire un chapitre']);
        // } else {
        //     header('Location: index.php?page=login&action=connexion');
        // }
    }

    /**
     * Permet d'écrire un nouveau chapitre
     *
     * @param array $post
     * @param array $files
     * @return void
     */
    public function newChapterAction(array $getData): void
    {
        //var_dump($getData);
        $postManager = new PostManager();
        $title = (isset($getData['post']['title'])) ? $getData['post']['title'] : null;
        $description = (isset($getData['post']['description'])) ? $getData['post']['description'] : null;
        $posted = (isset($getData['post']['public']) && $getData['post']['public'] == 1) ? 1 : 0;
        $file = (isset($getData['files']['image']['name'])) ? $getData['files']['image']['name'] : null;
        $tmpName = (isset($getData['files']['image']['tmp_name'])) ? $getData['files']['image']['tmp_name'] : null;
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        //var_dump($extention);
        $name = 'Jean Forteroche'; // Aller chercher nom en bdd ?
        //die();
        $errors = [];

        if (!empty($title) && !empty($description)) {
            if (!empty($tmpName)) {
                if (in_array($extention, $extentions)) {
                    $postManager->chapterWrite($title, $description, $name, $posted, $tmpName, $extention);
                    header('Location: index.php?page=adminChapters');
                } else {
                    $errors['image'] = 'Image n\'est pas valide! ';
                }
            } else {
                $errors['imageVide'] = 'Image obligatoire pour un chapitre ! ';
            }
        } else {
            $errors['contenu'] = 'Veuillez renseigner un contenu !';
        }
    }

/**
 * Renvoie la page login
 *
 * @param array $get
 * @return void
 */
    public function loginAction(array $session): void
    {
        $view = new View();
        $view->getView('backend', 'loginView', ['title' => 'Connexion']);

    }

    /**
     * Permet de se connecter
     *
     * @param array $session
     * @param array $post
     * @return void
     */
    public function connexionAction(array $getData, $session): void
    {
        $dashboardManager = new DashboardManager();
        $passwordBdd = $dashboardManager->getPass();
        $password = $getData["post"]['password'] ?? null;
        $errors = [];

        if (!empty($password)) {
            if (password_verify($password, $passwordBdd)) {
                $session['user'] = $password;
                header("Location: index.php?page=admin");
            } else {
                $errors['Password'] = 'Ce mot de passe n\'est pas bon pas !';
            }
        } else {
            $errors["Champs"] = 'Champs n\'est pas remplis !';
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
        header("Location: index.php?page=home");
    }
}