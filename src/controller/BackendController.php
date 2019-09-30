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
        if (!isset($session['mdp'])) {
            header('Location: index.php?page=login&action=connexion');
        }

        $commentManager = new CommentManager();
        $action = $getData['get']['action'] ?? null;
        $id = isset(($getData['get']['id'])) ? (int) $getData['get']['id'] : null;
        $idComment = isset(($getData['get']['idComment'])) ? (int) $getData['get']['idComment'] : null;

        if (isset($action)) {
            if ($action === 'valideComment') {
                $commentManager->validateComments($idComment);
            } else if ($action === 'removeComment') {
                $commentManager->deleteComments($idComment);
            }
        }

        if ($id !== null) {
            $comments = $commentManager->chapterComment($id);
        } elseif ($id === null) {
            $comments = $commentManager->getComments();
        }

        $view = new View();
        $view->getView('backend', 'adminCommentsView', ['comments' => $comments, 'title' => 'Dashboard', 'session' => $session]);
    }

/**
 * Récupère la liste des chapitres sur le Backend
 *
 * @param array $session
 * @return void
 */
    public function adminChaptersAction(array &$session, array $getData): void
    {
        if (!isset($session['mdp'])) {
            header('Location: index.php?page=login&action=connexion');
        }

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
        $view->getView('backend', 'adminChaptersView', ['chapters' => $chapters, 'title' => 'Listes chapitres', 'session' => $session, 'nbComments' => $nbComments]);
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
        if (!isset($session['mdp'])) {
            header('Location: index.php?page=login&action=connexion');
        }

        $view = new View();
        $postManager = new PostManager();
        $action = $getData['get']['action'] ?? null;
        $errors = $session['errors'] ?? null;
        unset($session['errors']);

        if (isset($action)) {
            $title = $getData['post']['title'] ?? null;
            $content = $getData['post']['content'] ?? null;
            $file = $getData['files']['image']['name'] ?? null;
            $tmpName = $getData['files']['image']['tmp_name'] ?? null;
            $posted = (isset($getData['post']['public']) && $getData['post']['public'] === 'on') ? 1 : 0;
            $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];

            if (!empty($file)) {
                $extention = strrchr($file, '.');
            } else if (empty($title) || empty($content)) {
                $errors['contenu'] = 'Veuillez renseigner un contenu !';
            } else if (empty($title)) {
                $errors['emptyTitle'] = "Veuillez mettre un titre";
            } else if (empty($content)) {
                $errors['emptyDesc'] = "Veuillez mettre un paragraphe";
            }

            //Modification chapitre
            if ($action === "adminEdit") {
                $id = (int) $getData['get']['id'];
                $postManager->editChapter($id, $title, $content, $posted);
                if (!isset($file) && empty($file)) {
                    $errors['valide'] = 'Image manquante ! ';
                } else if (!in_array($extention, $extentions) || $extention != ".png") {
                    $errors['valide'] = 'Image n\'est pas valide! ';
                }
                $postManager->editImageChapter($id, $title, $content, $tmpName, $extention, $posted);
            }

            //Nouveau chapitre
            if ($action === 'newChapter') {
                $name = $postManager->getName();
                if (!empty($tmpName)) {
                    $errors['imageVide'] = 'Image obligatoire pour un chapitre ! ';
                } else if (!in_array($extention, $extentions)) {
                    $errors['image'] = 'Image n\'est pas valide! ';
                }
                $postManager->chapterWrite($title, $content, $name["name_post"], $posted, $tmpName, $extention);
                header('Location: index.php?page=adminChapters');
            }
        }

        if (isset($getData['get']['id'])) {
            $title = 'Modifier un Chapitre ';
            $chapter = $postManager->getChapter((int) $getData['get']['id']);
        } else {
            $title = 'Ecrire un chapitre';
            $chapter = null;
        }

        $view->getView('backend', 'adminchapterView', ['chapter' => $chapter, 'title' => $title, 'errors' => $errors, 'session' => $session]);
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

            $userBdd = $dashboardManager->getUsers();
            $passwordBdd = $dashboardManager->getPass();
            $pseudo = $getData["post"]['pseudo'] ?? null;
            $password = $getData["post"]['password'] ?? null;

            if (empty($pseudo)) {
                $errors["pseudoEmpty"] = 'Veuillez mettre un pseudo ';
            } else if (empty($password)) {
                $errors["passwordEmpty"] = 'Veuillez mettre un mot de passe';
            } else if (!password_verify($password, $passwordBdd) && $pseudo !== $userBdd) {
                $errors['user'] = 'Identifiants Incorects';
            }

            $session['user'] = $pseudo;
            $session['mdp'] = $password;
            header('Location: index.php?page=adminChapters');
        }

        $view = new View();
        $view->getView('backend', 'loginView', ['title' => 'Connexion', 'errors' => $errors, 'session' => $session]);
    }

    public function adminProfilAction(&$session, array $getData): void
    {
        if (!isset($session['mdp'])) {
            header('Location: index.php?page=login&action=connexion');
        }

        $dashboardManager = new DashboardManager();
        $action = $getData['get']['action'] ?? null;
        $get = $getData['get'];
        $succes = (isset($session['succes'])) ? $session['succes'] : null;
        unset($session['succes']);
        $errors = (isset($session['errors'])) ? $session['errors'] : null;
        unset($session['errors']);

        if ($action === "update") {

            $pseudo = htmlspecialchars(trim($getData["post"]['pseudo'])) ?? null;
            $password = htmlspecialchars(trim($getData["post"]['password'])) ?? null;
            $passwordVerif = htmlspecialchars(trim($getData["post"]['passwordVerif'])) ?? null;

            if (empty($pseudo)) {
                $errors["pseudoEmpty"] = 'Veuillez mettre un pseudo ';
            } else if (empty($password)) {
                $errors["passwordEmpty"] = 'Veuillez mettre un mot de passe';
            } else if (empty($passwordVerif)) {
                $errors["passwordVerifEmpty"] = 'Veuillez confirmer le mot de passe';
            } else if ($password !== $passwordVerif) {
                $errors["passwordEmpty"] = 'les mots de passe ne correspond pas';
            }

            $dashboardManager->userReplace($pseudo);
            $session['user'] = $pseudo;
            $succes['user'] = "Utilisateur mis à jour";
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $dashboardManager->passReplace($pass);
            $session['mdp'] = $password;
            $succes['mdp'] = "Mot de passe mis à jour";
        }

        $view = new View();
        $view->getView('backend', 'adminProfil', ['title' => 'Mettre à jour profil', 'errors' => $errors, 'session' => $session, 'get' => $get]);
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