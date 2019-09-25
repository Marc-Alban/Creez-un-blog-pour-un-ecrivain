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
        if (isset($session['mdp'])) {

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
        if (isset($session['mdp'])) {
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
        if (isset($session['mdp'])) {
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
                }
                if (!empty($title) || !empty($content)) {
                    if (!empty($title)) {
                        if (!empty($content)) {

                            //Modification chapitre
                            if ($action === "adminEdit") {
                                $id = (int) $getData['get']['id'];
                                $postManager->editChapter($id, $title, $content, $posted);
                                if (isset($file) && !empty($file)) {
                                    if (in_array($extention, $extentions) || $extention = ".png") {
                                        $postManager->editImageChapter($id, $title, $content, $tmpName, $extention, $posted);
                                    } else {
                                        $errors['valide'] = 'Image n\'est pas valide! ';
                                    }
                                }
                            }

                            //Nouveau chapitre
                            if ($action === 'newChapter') {
                                $name = $postManager->getName();
                                if (!empty($tmpName)) {
                                    if (in_array($extention, $extentions)) {
                                        $postManager->chapterWrite($title, $content, $name["name_post"], $posted, $tmpName, $extention);
                                        header('Location: index.php?page=adminChapters');
                                    } else {
                                        $errors['image'] = 'Image n\'est pas valide! ';
                                    }
                                } else {
                                    $errors['imageVide'] = 'Image obligatoire pour un chapitre ! ';
                                }
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
            if (isset($getData['get']['id'])) {
                $title = 'Modifier un Chapitre ';
                $chapter = $postManager->getChapter((int) $getData['get']['id']);
            } else {
                $title = 'Ecrire un chapitre';
                $chapter = null;
            }
            $view->getView('backend', 'adminchapterView', ['chapter' => $chapter, 'title' => $title, 'errors' => $errors, 'session' => $session]);
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
            $userBdd = $dashboardManager->getUsers();
            $passwordBdd = $dashboardManager->getPass();
            $pseudo = $getData["post"]['pseudo'] ?? null;
            $password = $getData["post"]['password'] ?? null;

            if (isset($getData['post']['connexion'])) {
                if (!empty($pseudo)) {
                    if (!empty($password)) {
                        if ($pseudo === $userBdd) {
                            $session['user'] = $pseudo;
                            if (password_verify($password, $passwordBdd)) {
                                $session['mdp'] = $password;
                                header('Location: index.php?page=adminChapters');
                            } else {
                                $errors['Password'] = 'Ce mot de passe n\'est pas bon pas';
                            }
                        } else {
                            $errors["pseudoErrors"] = "Administrateur inconnu";
                        }
                    } else {
                        $errors["passwordEmpty"] = 'Veuillez mettre un mot de passe';
                    }
                } else {
                    $errors["pseudoEmpty"] = 'Veuillez mettre un pseudo ';
                }
            }

        }
        $view = new View();
        $view->getView('backend', 'loginView', ['title' => 'Connexion', 'errors' => $errors, 'session' => $session]);
    }

    public function adminProfilAction(&$session, array $getData)
    {
        if (isset($session['mdp'])) {
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

                if (!empty($pseudo)) {
                    if (!empty($password)) {
                        if (!empty($passwordVerif)) {
                            $dashboardManager->userReplace($pseudo);
                            $session['user'] = $pseudo;
                            $succes['user'] = "Utilisateur mis à jour";
                            if ($password === $passwordVerif) {
                                $pass = password_hash($password, PASSWORD_DEFAULT);
                                $dashboardManager->passReplace($pass);
                                $session['mdp'] = $password;
                                $succes['mdp'] = "Mot de passe mis à jour";
                            } else {
                                $errors["passwordEmpty"] = 'les mots de passe ne correspond pas';
                            }
                        } else {
                            $errors["passwordVerifEmpty"] = 'Veuillez mettre un mot de passe';
                        }
                    } else {
                        $errors["passwordEmpty"] = 'Veuillez mettre un mot de passe';
                    }
                } else {
                    $errors["pseudoEmpty"] = 'Veuillez mettre un pseudo ';
                }
            }
            $view = new View();
            $view->getView('backend', 'adminProfil', ['title' => 'Mettre à jour profil', 'errors' => $errors, 'session' => $session, 'get' => $get]);
        } else {
            header('Location: index.php?page=login&action=connexion');
        }
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