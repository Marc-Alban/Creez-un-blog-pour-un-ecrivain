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
    public function dashboardAction(): void
    {
        $commentManager = new CommentManager();
        $comments = $commentManager->getComments();
        $view = new View();
        $view->getView('backend', 'dashboardView', ['comments' => $comments]);
    }

    /**
     * Valide un commentaire
     *
     * @param integer $id
     * @return void
     */
    public function valideCommentAction(int $id): void
    {
        $commentManager = new CommentManager();
        $commentManager->validateComments($id);
        header('Location: index.php?page=admin');
    }

    /**
     * Supprime un commentaire
     *
     * @param integer $id
     * @return void
     */
    public function removeCommentAction(int $id): void
    {
        $commentManager = new CommentManager();
        $commentManager->deleteComments($id);
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
        $view->getView('backend', 'chaptersView', ['chapters' => $chapters]);
    }

/**
 * Permet de récupérer un chapitre
 *
 * @param integer $id
 * @return void
 */
    public function chapterAction(int $id): void
    {
        $postManager = new PostManager();
        $chapter = $postManager->getChapter($id);

        $view = new View();
        $view->getView('backend', 'chapterView', ['chapter' => $chapter]);
    }

    /**
     * Modifie un chapitre
     *
     * @param integer $id
     * @param array $post
     * @param array $files
     * @return void
     */
    public function editAction(int $id, array $post, array $files): void
    {
        $postManager = new PostManager();
        $title = (isset($post['title'])) ? $post['title'] : null;
        $content = (isset($post['content'])) ? $post['content'] : null;
        $posted = (isset($post['public']) && $post['public'] == 'on') ? 1 : 0;
        $file = (isset($files['image']['name'])) ? $files['image']['name'] : null;
        $tmpName = (isset($files['image']['tmp_name'])) ? $files['image']['tmp_name'] : null;
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        $errors = [];

        if (!empty($title) || !empty($content)) {
            $postManager->editChapter($id, $title, $content, $posted);
            if (isset($file) && !empty($file)) {
                if (in_array($extention, $extentions) || $extention = ".png") {
                    $postManager->editImageChapter($id, $title, $content, $tmpName, $extention, $posted);
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
    public function deleteAction(int $id): void
    {
        $postManager = new PostManager();
        $postManager->deleteChapter($id);
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
        $view->getView('backend', 'writeView', null);
    }

    /**
     * Permet d'écrire un nouveau chapitre
     *
     * @param array $post
     * @param array $files
     * @return void
     */
    public function writeFormAction(array $post, array $files): void
    {

        $postManager = new PostManager();
        $title = (isset($post['title'])) ? $post['title'] : null;
        $description = (isset($post['description'])) ? $post['description'] : null;
        $posted = (isset($post['public']) && $post['public'] == 1) ? 1 : 0;
        $file = (isset($files['image']['name'])) ? $files['image']['name'] : null;
        $tmpName = (isset($files['image']['tmp_name'])) ? $files['image']['tmp_name'] : null;
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
    public function loginAction(array $get): void
    {
        if (isset($get['action']) && $get['action'] === 'connexion') {
            $view = new View();
            $view->getView('backend', 'loginView', null);
        } else {
            header('Location: index.php?page=login&action=connexion');
        }
    }

    /**
     * Permet de se connecter
     *
     * @param array $session
     * @param array $post
     * @return void
     */
    public function connexionAction(array &$session, array $post): void
    {
        $dashboardManager = new DashboardManager();
        $passwordBdd = $dashboardManager->getPass();
        $password = (isset($post['password'])) ? $post['password'] : null;
        $errors = [];

        if (!empty($password)) {
            if (password_verify($password, $passwordBdd)) {
                $session['password'] = $password;
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