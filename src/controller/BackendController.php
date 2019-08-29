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
 */
    public function adminAction()
    {
        $commentManager = new CommentManager;
        $comments = $commentManager->getComments();
        $view = new View;
        $view->getView('backend', 'dashboardView', ['comments' => $comments]);
    }

    //########Action Commentaires Dashboard########//
    public function valideCommentAction(int $id)
    {
        $commentManager = new CommentManager;
        $commentManager->validateComments($id);
        header('Location: index.php?page=admin');
    }

    public function removeCommentAction(int $id)
    {
        $commentManager = new CommentManager;
        $commentManager->deleteComments($id);
        header('Location: index.php?page=admin');
    }

/**
 * Récupère la liste des chapitres sur le dashboard
 */
    public function chaptersAction()
    {
        $postManager = new PostManager;
        $chapters = $postManager->getChapters();
        $view = new View;
        $view->getView('backend', 'chaptersView', ['chapters' => $chapters]);
    }

/**
 *  Permet de récupérer un chapitre
 */
    public function updateAction(int $id)
    {
        $postManager = new PostManager;
        $chapter = $postManager->getChapter($id);
        $view = new View;
        $view->getView('backend', 'chapterView', ['chapter' => $chapter]);
    }

    public function editImageAction(int $id, array $post, array $files)
    {
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
                            $postManager->editImageChapter($id, $title, $content, $tmp_name, $extention, $posted);
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

    public function editAction(int $id, array $post)
    {
        $postManager = new PostManager;
        $title = (isset($post['title'])) ? $post['title'] : '';
        $content = (isset($post['content'])) ? $post['content'] : '';
        $posted = (isset($post['public']) && $post['public'] == 'on') ? 1 : 0;
        $errors = [];
        if (isset($post['modified'])) {
            if (!empty($title) || !empty($content)) {
                if (!empty($title)) {
                    if (!empty($content)) {
                        $postManager->editChapter($id, $title, $content, $posted);
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

    public function deleteAction(int $id)
    {
        $postManager = new PostManager;
        $postManager->deleteChapter($id);
        header('Location: index.php?page=adminEdit');
    }

/**
 * Récupère la page pour écrire un post
 */
    public function writeAction()
    {
        $view = new View;
        $view->getView('backend', 'writeView', null);
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
            $view = new View;
            $view->getView('backend', 'loginView', null);
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