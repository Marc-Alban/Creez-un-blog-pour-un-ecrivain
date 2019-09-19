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
    public function adminAction(): void
    {
        $commentManager = new CommentManager();
        $comments = $commentManager->getComments();
        $view = new View();
        $view->getView('backend', 'dashboardView', ['comments' => $comments, 'title' => 'Dashboard']);
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
        $commentManager->validateComments($getData['id']);
        header('Location: index.php?page=admin');
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
        $commentManager->deleteComments($getData['id']);
        header('Location: index.php?page=admin');
    }

/**
 * Récupère la liste des chapitres sur le dashboard
 *
 * @return void
 */
    public function chaptersAction(): void
    {
        $postManager = new PostManager();
        $chapters = $postManager->getChapters();
        $view = new View();
        $view->getView('backend', 'chaptersView', ['chapters' => $chapters, 'title' => 'Listes chapitres']);
    }

/**
 * Permet de récupérer un chapitre
 *
 * @param integer $id
 * @return void
 */
    public function chapterAction(array $getData): void
    {
        $postManager = new PostManager();
        $chapter = $postManager->getChapter($getData['id']);

        $view = new View();
        $view->getView('backend', 'chapterView', ['chapter' => $chapter, 'title' => 'Chapitre']);
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
        var_dump($getData);
        die();
        $postManager = new PostManager();
        $title = (isset($getData['post']['title'])) ? $getData['post']['title'] : null;
        $content = (isset($getData['post']['content'])) ? $getData['post']['content'] : null;
        $posted = (isset($getData['post']['public']) && $getData['post']['public'] == 'on') ? 1 : 0;
        $file = (isset($getData['files']['image']['name'])) ? $getData['files']['image']['name'] : null;
        $tmpName = (isset($getData['files']['image']['tmp_name'])) ? $getData['files']['image']['tmp_name'] : null;
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        $errors = [];

        if (!empty($title) || !empty($content)) {
            $postManager->editChapter($getData['get']['id'], $title, $content, $posted);
            if (isset($file) && !empty($file)) {
                if (in_array($extention, $extentions) || $extention = ".png") {
                    $postManager->editImageChapter($getData['get']['id'], $title, $content, $tmpName, $extention, $posted);
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
        $postManager->deleteChapter($getData['id']);
        header('Location: index.php?page=adminEdit');
    }

/**
 * Récupère la page pour écrire un post
 *
 * @return void
 */
    public function writeAction(): void
    {
        $view = new View();
        $view->getView('backend', 'writeView', ['title' => 'Ecrire un chapitre']);
    }

    /**
     * Permet d'écrire un nouveau chapitre
     *
     * @param array $post
     * @param array $files
     * @return void
     */
    public function writeFormAction(array $getData): void
    {

        $postManager = new PostManager();
        $title = (isset($getData['post']['title'])) ? $getData['post']['title'] : null;
        $description = (isset($getData['post']['description'])) ? $getData['post']['description'] : null;
        $posted = (isset($getData['post']['public']) && $getData['post']['public'] == 1) ? 1 : 0;
        $file = (isset($getData['files']['image']['name'])) ? $getData['files']['image']['name'] : null;
        $tmpName = (isset($getData['files']['image']['tmp_name'])) ? $getData['files']['image']['tmp_name'] : null;
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        $name = 'Jean Forteroche'; // Aller chercher nom en bdd ?
        $errors = [];

        if (!empty($title) && !empty($description)) {
            if (!empty($tmpName)) {
                if (in_array($extention, $extentions)) {
                    $postManager->chapterWrite($title, $description, $name, $posted, $tmpName, $extention);
                    header('Location: index.php?page=adminEdit');
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
    public function loginAction(): void
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
    public function connexionAction(array $getData): void
    {
        $dashboardManager = new DashboardManager();
        $passwordBdd = $dashboardManager->getPass();
        $password = (isset($getData['post']['password'])) ? $getData['post']['password'] : null;
        $errors = [];

        if (!empty($password)) {
            if (password_verify($password, $passwordBdd)) {
                $getData['session']['password'] = $password;
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