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
    public function getDashboardAction(int $id = null, int $action = null)
    {
        $commentManager = new CommentManager;
        $comments = $commentManager->getComments();

        if (isset($id) && isset($action) && $action = 1) {
            $commentManager->validateComments($id);
        } else {
            $commentManager->deleteComments($id);
        }

        ob_start();
        require 'view/backend/headerView.php';
        require 'view/backend/dashboardView.php';
        $content = ob_get_clean();
        require 'view/backend/template.php';
    }

/**
 * Récupère la liste des chapitres
 *
 * @return void
 */
    public function getChapitresAction()
    {
        $postManager = new PostManager;
        $chapitres = $postManager->getChapitres();

        ob_start();
        require 'view/backend/headerView.php';
        require 'view/backend/listView.php';
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
    public function getChapitreEditAction(int $id, string $title = '', string $content = '', string $tmp_name = '', int $posted = null, int $action = null, string $file = '')
    {
        $postManager = new PostManager;
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        $errors = [];

        if ($action === 1) {
            //Vérification des champs vides
            if (!empty($title) || !empty($content)) {
                //Vérification du champs vide title
                if (!empty($title)) {
                    //Vérification du champs vide content
                    if (!empty($content)) {
                        //Vérification de l'extention par rapport au tableau extention(s) ou bien à l'extention .png
                        if (in_array($extention, $extentions) || $extention = ".png") {
                            //Mise à jour du chapitre
                            $postManager->editChapitre($id, $title, $content, $tmp_name, $extention, $posted);
                            //Redirection sur la même page pour actualiser les données;
                            header('Location: index.php?page=postEdit&id=' . $id);
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
        } else if ($action === 2) {
            $postManager->deleteChapitre($id);
        } else {
            $chapitre = $postManager->getChapitre($id);
        }

        header("Location: index.php?page=list");
        ob_start();
        require 'view/backend/headerView.php';
        require 'view/backend/postView.php';
        $content = ob_get_clean();
        require 'view/backend/template.php';
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
    public function getWriteViewAction(string $title = '', string $content = '', int $posted = 0, string $tmp_name = '', int $action = null, string $file = '')
    {
        $postManager = new PostManager;
        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
        $extention = strrchr($file, '.');
        $name = 'Jean';
        $errors = [];

        if (isset($action) && $action === 1) {
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
                                $postManager->chapitreWrite($title, $content, $name, $posted, $tmp_name, $action, $extention);
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
        } else {
            $post = $postManager->chapitreWrite('', '', '', null, '', '');
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
    public function getLoginViewAction($pass = '')
    {
        $dashboardManager = new DashboardManager;
        $passBdd = $dashboardManager->getPass();

        //insertion du mot de passe envoyé dans une variable
        $password = htmlspecialchars(trim($pass));
        //si champs vide
        if (empty($password)) {
            $error["Champs"] = 'Champs n\'est pas remplis !';
        }

        //Vérification du mot de passe envoyé avec celui en bdd
        if (password_verify($password, $passBdd)) {
            return $password;
        } else {
            $error['Password'] = 'Ce mot de passe n\'est pas bon pas !';
        }

        ob_start();
        require 'view/backend/loginView.php';
        $content = ob_get_clean();
        require 'view/backend/template.php';
    }

    public function logoutAction()
    {
        $dashboardManager = new DashboardManager;
        $dashboardManager->logoutUser();
        header("Location: index.php?page=home");
    }
}