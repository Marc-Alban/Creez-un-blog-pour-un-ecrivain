<?php
declare (strict_types = 1);

use Openclassroom\Blog\Model\Frontend\CommentsManager;
use Openclassroom\Blog\Model\Frontend\PostManager;

require 'model/frontend/CommentsManager.php';
require 'model/frontend/PostManager.php';
require 'model/ViewPage.php';

class FrontendController
{

/**
 * Renvoie les chapitres sur la page Accueil
 *
 * @return void
 */
    public function homeAction()
    {
        $postManager = new PostManager;
        $chapters = $postManager->getLimitedChapters();

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
    public function chaptersAction()
    {
        $postManager = new PostManager;
        $chapters = $postManager->getchapters();

        ob_start();
        require 'view/frontend/headerView.php';
        require 'view/frontend/chaptersView.php';
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
    public function chapterAction(int $id)
    {
        //fonction qui transforme la chaine en integer
        $id = intval($id);

        $postManager = new PostManager;
        $chapter = $postManager->getChapter($id);

        $commentManager = new CommentsManager;
        $comments = $commentManager->getComments($id);

        ob_start();
        require 'view/frontend/headerView.php';
        require 'view/frontend/chapterView.php';
        require 'view/frontend/footerView.php';
        $content = ob_get_clean();
        require 'view/frontend/template.php';

    }

    public function signalAction(int $comment_id)
    {
        $commentManager = new CommentsManager;
        $commentManager->signalComment($comment_id);
    }

    public function sendCommentAction(string $name, string $comment, int $id)
    {
        $commentManager = new CommentsManager;
        $id = intval($id);
        $errors = [];

        //Vérification des champs vides
        if (!empty($name) || !empty($comment)) {
            if (!empty($name)) {
                if (!empty($comment)) {
                    htmlspecialchars(trim($name));
                    htmlspecialchars(trim($comment));
                    //Vérification des érreurs
                    if (empty($errors)) {
                        //Insertion d'un commentaire en bdd
                        $commentManager->setComment($name, $comment, $id);
                    }
                } else {
                    $errors['content'] = 'le champs message est vide';
                }
            } else {
                $errors['name'] = 'le champs pseudo est vide';
            }
        } else {
            $errors['Champs'] = 'Tous les champs sont vides';
        }
    }

/**
 * Renvoie la page erreur
 *
 * @return void
 */
    public function errorAction()
    {
        ob_start();
        require 'view/frontend/headerView.php';
        require 'view/frontend/errorView.php';
        require 'view/frontend/footerView.php';
        $content = ob_get_clean();
        require 'view/frontend/template.php';

    }

}