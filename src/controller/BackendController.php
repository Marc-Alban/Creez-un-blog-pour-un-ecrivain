<?php
declare (strict_types = 1);
namespace Blog\Controller;

use Blog\Model\AdminsManager;
use Blog\Model\CommentsManager;
use Blog\Model\PostsManager;
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

        $commentManager = new CommentsManager();
        $action = $getData['get']['action'] ?? null;
        $comments = null;
        $id = isset($getData['get']['id']) ? (int) $getData['get']['id'] : null;
        $idComment = isset($getData['get']['idComment']) ? (int) $getData['get']['idComment'] : null;

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
            $comments = $commentManager->getComments(null);
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
        if (empty($session['mdp'])) {
            header('Location: index.php?page=login&action=connexion');
        }

        $postManager = new PostsManager();
        $AdminsManager = new AdminsManager;
        $commentManager = new CommentsManager();
        $action = $getData['get']['action'] ?? null;

        if ($action === 'delete') {
            $postManager->deleteChapter((int) $getData['get']['id']);
        } else if ($action === "logout") {
            $AdminsManager->logoutUser();
            unset($session['token']);
            header('Location: index.php?page=login&action=connexion');
        }

        $chapters = $postManager->getChapters(2);
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

        if ($session['valideToken'] === false) {$errors["token"] = "Formulaire Incorrect";}

        $postManager = new PostsManager();
        $view = new View();
        $action = $getData['get']['action'] ?? null;
        $errors = $session['errors'] ?? null;
        unset($session['errors']);

        if (isset($action)) {
            $title = $getData['post']['title'] ?? null;
            $content = $getData['post']['content'] ?? null;
            $file = (!empty($getData['files']['image']['name'])) ? $getData['files']['image']['name'] : '.png';
            $tmpName = $getData['files']['image']['tmp_name'] ?? null;
            $posted = (isset($getData['post']['public']) && $getData['post']['public'] === 'on') ? 1 : 0;
            $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
            $extention = strrchr($file, '.');

            if (empty($title) || empty($content)) {
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
                if (!isset($file) || empty($file)) {
                    $errors['empty'] = 'Image manquante ! ';
                } else if (in_array($extention, $extentions) === false) {
                    $errors['valide'] = 'Image n\'est pas valide! ';
                } else if (empty($errors)) {
                    $postManager->editImageChapter($id, $title, $content, $tmpName, $extention, $posted);
                }
            }

            //Nouveau chapitre
            if ($action === 'newChapter') {
                $name = $postManager->getName();
                if (empty($tmpName)) {
                    $errors['imageVide'] = 'Image obligatoire pour un chapitre ! ';
                } else if (in_array($extention, $extentions) === false) {
                    $errors['image'] = 'Image n\'est pas valide! ';
                } else if (empty($errors)) {
                    $postManager->chapterWrite($title, $content, $name["name_post"], $posted, $tmpName, $extention);
                    header('Location: index.php?page=adminChapters');
                }
            }
        }

        $title = 'Ecrire un chapitre';
        $chapter = null;

        if (isset($getData['get']['id'])) {
            $title = 'Modifier un Chapitre ';
            $chapter = $postManager->getChapter((int) $getData['get']['id'], 1);
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

        $AdminsManager = new AdminsManager();
        $action = $getData['get']['action'] ?? null;
        $errors = $session['errors'] ?? null;
        unset($session['errors']);

        if (isset($getData['post']['connexion']) && $action === "connexion") {

            if ($session['valideToken'] === false) {$errors["token"] = "Formulaire Incorrect";}

            $passwordBdd = $AdminsManager->getPass();
            $pseudo = $getData["post"]['pseudo'] ?? null;
            $userBdd = $AdminsManager->getUsers($pseudo);
            $password = $getData["post"]['password'] ?? null;

            if (empty($pseudo)) {
                $errors["pseudoEmpty"] = 'Veuillez mettre un pseudo ';
            } else if (empty($password)) {
                $errors["passwordEmpty"] = 'Veuillez mettre un mot de passe';
            } else if (!password_verify($password, $passwordBdd) || $userBdd === null) {
                $errors['identifiants'] = 'Identifiants Incorrect';
            }

            if (empty($errors)) {
                $session['user'] = $pseudo;
                $session['mdp'] = $password;
                header('Location: index.php?page=adminChapters');
            }
        }

        $view = new View();
        $view->getView('backend', 'loginView', ['title' => 'Connexion', 'errors' => $errors, 'session' => $session]);
    }

    public function adminProfilAction(&$session, array $getData): void
    {
        if (!isset($session['mdp'])) {
            header('Location: index.php?page=login&action=connexion');
        }

        $AdminsManager = new AdminsManager();
        $action = $getData['get']['action'] ?? null;
        $get = $getData['get'];
        $succes = $session['succes'] ?? null;
        unset($session['succes']);
        $errors = $session['errors'] ?? null;
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

            if (empty($errors)) {
                $AdminsManager->userReplace($pseudo);
                $session['user'] = $pseudo;
                $pass = password_hash($password, PASSWORD_DEFAULT);
                $AdminsManager->passReplace($pass);
                $session['mdp'] = $password;
                $succes['identifiant'] = "Identifiant mis à jours";
            }
        }

        $view = new View();
        $view->getView('backend', 'adminProfil', ['title' => 'Mettre à jour profil', 'errors' => $errors, 'succes' => $succes, 'session' => $session, 'get' => $get]);
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