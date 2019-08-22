<?php
declare (strict_types = 1);
use Openclassroom\Blog\Model\Backend\CommentManager;
use Openclassroom\Blog\Model\backend\DashboardManager;
use Openclassroom\Blog\Model\Backend\PostManager;

require 'model/backend/CommentsManager.php';
require 'model/backend/DashboardManager.php';
require 'model/backend/PostManager.php';

class BackendController
{

/**
 * Retourne la page home du dashboard
 */
    public function adminAction()
    {
        $commentManager = new CommentManager;
        $comments = $commentManager->getComments();

        $viewPage = new ViewPage;
        $content = $viewPage->getView('backend', 'dashboardView');
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

        $viewPage = new ViewPage;
        $content = $viewPage->getView('backend', 'chaptersView');
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

        $viewPage = new ViewPage;
        $content = $viewPage->getView('backend', 'chapterView');
        require 'view/backend/template.php';
    }

    public function editImageAction($id, array &$post, array &$files)
    {

        $idInt = intval($id);
        $postManager = new PostManager;
        $title = $post['title'];
        $content = $post['content'];
        $posted = (isset($post['public']) == 'on') ? 1 : 0;
        $file = $files['image']['name'];
        $tmp_name = $files['image']['tmp_name'];
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        $errors = [];

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

    public function editAction($id, &$post)
    {
        $postManager = new PostManager;
        $idInt = intval($id);
        $title = $post['title'];
        $content = $post['content'];
        $posted = (isset($post['public']) == 'on') ? 1 : 0;
        $errors = [];

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

    public function deleteAction($id)
    {
        $idInt = intval($id);
        $postManager = new PostManager;
        $postManager->deleteChapter($$idInt);
        header('Location: index.php?page=adminEdit');
    }

/**
 * Récupère la page pour écrire un post
 */
    public function writeAction()
    {
        $viewPage = new ViewPage;
        $content = $viewPage->getView('backend', 'writeView');
        require 'view/frontend/template.php';
    }

    public function writeFormAction(array $post, array $files)
    {

        $postManager = new PostManager;
        $title = $post['title'];
        $description = $post['description'];
        $posted = (isset($post['public']) == 'on') ? 1 : 0;
        $file = $files['image']['name'];
        $tmp_name = $files['image']['tmp_name'];
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        $name = 'Jean';
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
    public function loginAction()
    {
        ob_start();
        require 'view/backend/loginView.php';
        $content = ob_get_clean();
        require 'view/backend/template.php';
    }

    public function connexionAction(array $session)
    {

        var_dump($session);
        die();
        $dashboardManager = new DashboardManager;
        $passwordBdd = $dashboardManager->getPass();
        $password = $session['password'];
        $errors = [];

        if (!empty($password)) {
            if ($password > 5) {
                if (password_verify($password, $passwordBdd)) {
                    htmlspecialchars(trim($password));
                    return $password;
                } else {
                    $errors['Password'] = 'Ce mot de passe n\'est pas bon pas !';
                }
            } else {
                $errors['size'] = 'Le mot de passe doit être supérieur à 5 caractères';
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