<?php
declare (strict_types = 1);

use Openclassroom\Blog\Model\Frontend\CommentsManager;
use Openclassroom\Blog\Model\Frontend\PostManager;

require 'model/frontend/CommentsManager.php';
require 'model/frontend/PostManager.php';

class FrontendController
{

/**
 * Renvoie les chapitres sur la page Accueil
 *
 * @return void
 */
    public function getHomeViewAction()
    {
        $postManager = new PostManager;
        $posts = $postManager->getLimitedChapitres();

        ob_start();
        require 'view/frontend/headerView.php';
        require 'view/frontend/homeView.php';
        require 'view/frontend/footerView.php';
        $content = ob_get_clean();
        require 'view/frontend/template.php';
    }

/**
 * Renvoie les chapitres sur la page chapitres
 *
 * @return void
 */
    public function ChapitresAction()
    {
        $postManager = new PostManager;
        $posts = $postManager->getChapitres();

        ob_start();
        require 'view/frontend/headerView.php';
        require 'view/frontend/chapitreView.php';
        require 'view/frontend/footerView.php';
        $content = ob_get_clean();
        require 'view/frontend/template.php';
    }

/**
 * Renvoie les commentaires  et le chapitre sur la page
 * Insert si envoie de commentaire ou signal un commentaire
 *
 * @param string $name
 * @param string $comment
 * @param integer $id
 * @param integer $commentid
 * @return void
 */
    public function chapitreViewAction(string $name = null, string $comment = null, int $id, int $idComment = null)
    {
        //fonction qui transforme la chaine en integer
        $id = intval($id);

        $postManager = new PostManager;
        $post = $postManager->getChapitre($id);

        $commentManager = new CommentsManager;
        $responses = $commentManager->getComments($id);

        if (isset($idComment)) {
            //fonction qui transforme la chaine en integer
            $idSignal = intval($idComment);
            $commentManager->signalComment($idSignal);
        }

        if (isset($name) && isset($comment)) {

            htmlspecialchars(trim($name));
            htmlspecialchars(trim($comment));
            $errors = [];

            //Vérification des champs vides
            if (!empty($name) || !empty($comment)) {
                //Vérification des érreurs
                if (empty($errors)) {
                    //Insertion d'un commentaire en bdd
                    $commentManager->setComment($name, $comment, $id);
                }
            } else {
                $errors['Champs vide'] = 'Tous les champs sont vides';
            }
        }

        ob_start();
        require 'view/frontend/headerView.php';
        require 'view/frontend/postView.php';
        require 'view/frontend/footerView.php';
        $content = ob_get_clean();
        require 'view/frontend/template.php';

    }

/**
 * Renvoie la page erreur
 *
 * @return void
 */
    public function getErrorAction()
    {
        ob_start();
        require 'view/frontend/headerView.php';
        require 'view/frontend/errorView.php';
        $content = ob_get_clean();
        require 'view/frontend/template.php';

    }

}