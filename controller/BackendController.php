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
 * valide un commentaire
 * suprime un commentaire
 *
 * @param integer $id
 * @return void
 */
    public function adminAction()
    {
        $commentManager = new CommentManager;
        $comments = $commentManager->getComments();

        ob_start();
        require 'view/backend/headerView.php';
        require 'view/backend/dashboardView.php';
        $content = ob_get_clean();
        require 'view/backend/template.php';
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
 * Récupère la liste des chapitres
 *
 * @return void
 */
    public function chaptersAction()
    {
        $postManager = new PostManager;
        $chapters = $postManager->getChapters();

        ob_start();
        require 'view/backend/headerView.php';
        require 'view/backend/chaptersView.php';
        $content = ob_get_clean();
        require 'view/backend/template.php';
    }

/**
 *  Permet de récupérer un chapitre
 * et de l'éditer
 * ou de le suprimer
 *
 * @param integer $id
 * @param string $title
 * @param string $content
 * @param string $tmp_name
 * @param integer $posted
 * @param integer $action
 * @param string $file
 * @return void
 */
    public function updateAction(int $id)
    {
        $postManager = new PostManager;
        $chapter = $postManager->getChapter($id);

        ob_start();
        require 'view/backend/headerView.php';
        require 'view/backend/chapterView.php';
        $content = ob_get_clean();
        require 'view/backend/template.php';
    }

    public function editImageAction($id, $title, $content, $tmp_name, $posted, $file)
    {
        $postManager = new PostManager;
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        $errors = [];
        //Vérification des champs vides
        if (!empty($title) || !empty($content)) {
            //Vérification du champs vide title
            if (!empty($title)) {
                //Vérification du champs vide content
                if (!empty($content)) {
                    //Vérification de l'extention par rapport au tableau extention(s) ou bien à l'extention .png
                    if (in_array($extention, $extentions) || $extention = ".png") {
                        //Mise à jour du chapitre
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

    public function editAction($id, $title, $content, $posted)
    {
        $postManager = new PostManager;
        $errors = [];

        //Vérification des champs vides
        if (!empty($title) || !empty($content)) {
            //Vérification du champs vide title
            if (!empty($title)) {
                //Vérification du champs vide content
                if (!empty($content)) {
                    //Mise à jour du chapitre
                    $postManager->editChapter($id, $title, $content, $posted);
                    //Redirection sur la même page pour actualiser les données;
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
        $postManager = new PostManager;
        $postManager->deleteChapter($id);
    }

/**
 * Récupère la page pour écrire un post
 * et envoi en bdd si il y a un envoi
 *
 * @param string $title
 * @param string $content
 * @param integer $posted
 * @param string $tmp_name
 * @param integer $action
 * @param string $file
 * @return void
 */
    public function getWriteViewAction(string $title = '', string $content = '', int $posted, string $tmp_name = '', int $action = null, string $file = '')
    {
        $postManager = new PostManager;
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        $name = 'Jean';
        $errors = [];

        if (isset($action) && $action == 1) {
            //Test si champs vide
            if (!empty($title) || !empty($content)) {
                //test champs vide title
                if (!empty($title)) {
                    //test champs vide content
                    if (!empty($content)) {

                        //test extention(s): pour  savoir si l'extention correspon aux extention dans le tableau
                        if (in_array($extention, $extentions)) {
                            //test champs vide name
                            if (!empty($name)) {
                                //Insertion du chapitre en bdd
                                $postManager->chapitreWrite($title, $content, $name, $posted, $tmp_name, $extention);
                            } else {
                                $errors['nameEmpty'] = 'Nom manquant !';
                            }
                        } else {
                            $errors['image'] = 'Image n\'est pas valide! ';
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

        ob_start();
        require 'view/backend/headerView.php';
        require 'view/backend/writeView.php';
        $content = ob_get_clean();
        require 'view/backend/template.php';
    }

/**
 * Renvoie la page login sur le dashboard
 * Ainsi que récupère le mot de passe
 *
 * @return void
 */
    public function loginAction()
    {
        ob_start();
        require 'view/backend/loginView.php';
        $content = ob_get_clean();
        require 'view/backend/template.php';
    }

    public function connexionAction(int $password)
    {
        $dashboardManager = new DashboardManager;
        $passwordBdd = $dashboardManager->getPass();
        $errors = [];
        //si champs vide
        if (!empty($password)) {
            if ($password > 5) {
                $pass = strval($password);
                //Vérification du mot de passe envoyé avec celui en bdd
                if (password_verify($pass, $passwordBdd)) {
                    //insertion du mot de passe envoyé dans une variable
                    htmlspecialchars(trim($pass));
                    return $pass;
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