<?php
declare (strict_types = 1);
use Openclassroom\Blog\Model\Backend\CommentManager;
use Openclassroom\Blog\Model\backend\DashboardManager;
use Openclassroom\Blog\Model\Backend\PostManager;
use Openclassroom\Blog\Model\ViewManager;

require_once 'model/backend/CommentsManager.php';
require_once 'model/backend/DashboardManager.php';
require_once 'model/backend/PostManager.php';
require_once 'model/ViewManager.php';

class BackendController
{

/**
 * Retourne la page home du dashboard
 */
    public function adminAction()
    {
        $commentManager = new CommentManager;
        $comments = $commentManager->getComments();
        $title = 'Dashboard-Administration';
        $ViewManager = new ViewManager;
        $content = $ViewManager->getView('backend', 'dashboardView', ['comments' => $comments]);
        require 'view/backend/template.php';
    }

    //########Action Commentaires Dashboard########//
    public function valideCommentAction(string $id)
    {
        $idInt = intval($id);
        $commentManager = new CommentManager;
        $commentManager->validateComments($idInt);
        header('Location: index.php?page=admin');
    }

    public function removeCommentAction(string $id)
    {
        $idInt = intval($id);
        $commentManager = new CommentManager;
        $commentManager->deleteComments($idInt);
        header('Location: index.php?page=admin');
    }

/**
 * Récupère la liste des chapitres sur le dashboard
 */
    public function chaptersAction()
    {
        $postManager = new PostManager;
        $chapters = $postManager->getChapters();
        $title = 'Liste des chapitres';
        $ViewManager = new ViewManager;
        $content = $ViewManager->getView('backend', 'chaptersView', ['chapters' => $chapters]);
        require 'view/backend/template.php';
    }

/**
 *  Permet de récupérer un chapitre
 */
    public function updateAction(string $id)
    {
        $idInt = intval($id);
        $postManager = new PostManager;
        $chapter = $postManager->getChapter($idInt);
        $title = 'Mettre à jour un chapitre';
        $ViewManager = new ViewManager;
        $content = $ViewManager->getView('backend', 'chapterView', ['chapter' => $chapter]);
        require 'view/backend/template.php';
    }

    public function editImageAction($id, array $post, array $files)
    {
        $idInt = intval($id);
        $postManager = new PostManager;
        $title = (isset($post['title'])) ? $post['title'] : '';
        $content = (isset($post['content'])) ? $post['content'] : '';
        $posted = (isset($post['public']) && $post['public'] == 'on') ? 1 : 0;
        $file = (isset($files['image']['name'])) ? $files['image']['name'] : '';
        $tmp_name = (isset($files['image']['tmp_name'])) ? $files['image']['tmp_name'] : '';
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        $errors = [];
        if (isset($post['modified'])) {
            if (!empty($title) || !empty($content)) {
                if (!empty($title)) {
                    if (!empty($content)) {
                        if (in_array($extention, $extentions) || $extention = ".png") {
                            $postManager->editImageChapter($idInt, $title, $content, $tmp_name, $extention, $posted);
                        } else {
                            $errors['valide'] = 'Image n\'est pas valide! ';
                        }
                    } else {
                        $errors['vide'] = 'Veuillez mettre un contenu !';
                    }
                } else {
                    $errors['title'] = 'Veuillez mettre un titre !';
                }
            } else {
                $errors['ChampsVide'] = 'Veuillez remplir tous les champs !';
            }
        }
    }

    public function editAction($id, $post)
    {
        $postManager = new PostManager;
        $idInt = intval($id);
        $title = (isset($post['title'])) ? $post['title'] : '';
        $content = (isset($post['content'])) ? $post['content'] : '';
        $posted = (isset($post['public']) && $post['public'] == 'on') ? 1 : 0;
        $errors = [];
        if (isset($post['modified'])) {
            if (!empty($title) || !empty($content)) {
                if (!empty($title)) {
                    if (!empty($content)) {
                        $postManager->editChapter($idInt, $title, $content, $posted);
                    } else {
                        $errors['vide'] = 'Veuillez mettre un contenu !';
                    }
                } else {
                    $errors['title'] = 'Veuillez mettre un titre !';
                }
            } else {
                $errors['ChampsVide'] = 'Veuillez remplir tous les champs !';
            }
        }

    }

    public function deleteAction($id)
    {
        $idInt = intval($id);
        $postManager = new PostManager;
        $postManager->deleteChapter($idInt);
        header('Location: index.php?page=adminEdit');
    }

/**
 * Récupère la page pour écrire un post
 */
    public function writeAction()
    {
        $title = 'Ecrire un chapitre';
        $ViewManager = new ViewManager;
        $content = $ViewManager->getView('backend', 'writeView', null);
        require 'view/backend/template.php';
    }

    public function writeFormAction(array $post, array $files)
    {

        $postManager = new PostManager;
        $title = (isset($post['title'])) ? $post['title'] : '';
        $description = (isset($post['description'])) ? $post['description'] : '';
        $posted = (isset($post['public']) && $post['public'] == 1) ? 1 : 0;
        $file = (isset($files['image']['name'])) ? $files['image']['name'] : '';
        $tmp_name = (isset($files['image']['tmp_name'])) ? $files['image']['tmp_name'] : '';
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        $name = 'Jean Forteroche';
        $errors = [];

        if (!empty($title) || !empty($description)) {

            if (!empty($title)) {
                if (!empty($description)) {
                    if (!empty($tmp_name)) {
                        if (in_array($extention, $extentions)) {
                            if (!empty($name)) {
                                $postManager->chapterWrite($title, $description, $name, $posted, $tmp_name, $extention);
                                header('Location: index.php?page=adminEdit');
                            } else {
                                $errors['nameEmpty'] = 'Nom manquant !';
                            }
                        } else {
                            $errors['image'] = 'Image n\'est pas valide! ';
                        }
                    } else {
                        $errors['imageVide'] = 'Image obligatoire pour un chapitre ! ';
                    }
                } else {
                    $errors['textEmpty'] = 'Veuillez renseigner du contenu ! ';
                }
            } else {
                $errors['titleEmpty'] = 'Veuillez renseigner un titre !';
            }
        } else {
            $errors['fieldsEmpty'] = 'Veuillez remplir les champs';
        }
    }

/**
 * Renvoie la page login
 *
 */
    public function loginAction(array $get)
    {
        if (isset($get['action']) && $get['action'] == 'connexion') {
            $title = 'Page de connexion';
            ob_start();
            require 'view/backend/loginView.php';
            $content = ob_get_clean();
            require 'view/backend/template.php';
        } else {
            header('Location: index.php?page=login&action=connexion');
        }

    }

    public function connexionAction(array &$session, array $post)
    {
        $dashboardManager = new DashboardManager;
        $passwordBdd = $dashboardManager->getPass();
        $password = (isset($post['password'])) ? $post['password'] : '';
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

    public function logoutAction()
    {
        $dashboardManager = new DashboardManager;
        $dashboardManager->logoutUser();
        header("Location: index.php?page=home");
    }
}