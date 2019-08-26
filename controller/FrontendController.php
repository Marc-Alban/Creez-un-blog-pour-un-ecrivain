<?php
declare (strict_types = 1);

use Openclassroom\Blog\Model\Frontend\CommentsManager;
use Openclassroom\Blog\Model\Frontend\PostManager;
use Openclassroom\Blog\Model\ViewManager;

require 'model/frontend/CommentsManager.php';
require 'model/frontend/PostManager.php';
require 'model/ViewManager.php';

class FrontendController
{

/**
 * Renvoie les chapitres sur la page Accueil
 *
 */
    public function homeAction()
    {
        $postManager = new PostManager;
        $chapters = $postManager->getLimitedChapters();
        $title = 'Accueil - Livre Jean Forteroche';
        $ViewManager = new ViewManager;
        $content = $ViewManager->getView('frontend', 'homeView', ['chapters' => $chapters]);
        require 'view/frontend/template.php';
    }

/**
 * Renvoie les chapitres sur la page chapitres
 *
 */
    public function chaptersAction()
    {
        $postManager = new PostManager;
        $chapters = $postManager->getchapters();
        $title = 'Chapitres - Jean Forteroche';
        $ViewManager = new ViewManager;
        $content = $ViewManager->getView('frontend', 'chaptersView', ['chapters' => $chapters]);
        require 'view/frontend/template.php';
    }

/**
 * Renvoie les commentaires  et le chapitre sur la page
 */
    public function chapterAction(string $id)
    {
        $idInt = intval($id);

        $postManager = new PostManager;
        $chapter = $postManager->getChapter($idInt);

        $commentManager = new CommentsManager;
        $comments = $commentManager->getComments($idInt);
        $title = 'Chapitre - Jean Forteroche';
        $ViewManager = new ViewManager;
        $content = $ViewManager->getView('frontend', 'chapterView', ['chapter' => $chapter, 'comments' => $comments]);
        require 'view/frontend/template.php';
    }

    public function signalAction(string $idComment, string $id)
    {
        $idInt = intval($id);
        $commentID = intval($idComment);

        $commentManager = new CommentsManager;
        $commentManager->signalComment($commentID);

        header('Location: index.php?page=chapter&id=' . $idInt);
    }

    public function sendCommentAction(array $post, string $id)
    {
        $name = (isset($post['name'])) ? $post['name'] : '';
        $comment = (isset($post['comment'])) ? $post['comment'] : '';
        $idInt = intval($id);
        $errors = [];
        $commentManager = new CommentsManager;

        if (isset($post['submit'])) {
            if (!empty($name) || !empty($comment)) {
                if (!empty($name)) {
                    if (!empty($comment)) {
                        htmlspecialchars(trim($name));
                        htmlspecialchars(trim($comment));
                        if (empty($errors)) {
                            $commentManager->setComment($name, $comment, $idInt);
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
    }

/**
 * Renvoie la page erreur
 */
    public function errorAction()
    {
        $title = 'Page - Introuvable';
        $ViewManager = new ViewManager;
        $content = $ViewManager->getView('frontend', 'errorView', null);
        require 'view/frontend/template.php';
    }

}