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
    public function getDashboardAction(int $id)
    {
        $commentManager = new CommentManager;
        $commentManager->validateComments($id);
        $commentManager->deleteComments($id);
        $comments = $commentManager->getComments();

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
 * Permet de récupérer un chapitre
 * et de l'éditer
 * ou de le suprimer
 *
 * @param integer $id
 * @param string $title
 * @param string $content
 * @param string $tmp_name
 * @param string $extention
 * @param integer $posted
 * @return void
 */
    public function getChapitreEditAction(int $id, string $title, string $content, string $tmp_name, string $extention, int $posted)
    {
        $postManager = new PostManager;
        $postManager->editChapitre($id, $title, $content, $tmp_name, $extention, $posted);
        $postManager->deleteChapitre($id);
        $chapitre = $postManager->getChapitre($id);
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
 * @param string $name
 * @param integer $posted
 * @param string $tmp_name
 * @param string $extention
 * @return void
 */
    public function getWriteViewAction(string $title, string $content, string $name, int $posted, string $tmp_name, string $extention)
    {
        $postManager = new PostManager;
        $post = $postManager->chapitreWrite($title, $content, $name, $posted, $tmp_name, $extention);

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
    public function getLoginViewAction()
    {
        $dashboardManager = new DashboardManager;
        $pass = $dashboardManager->getPass();
        ob_start();
        require 'view/backend/loginView.php';
        $content = ob_get_clean();
        require 'view/backend/template.php';
    }

    public function logoutAction()
    {
        $dashboardManager = new DashboardManager;
        $dashboardManager->logoutUser();
    }
}