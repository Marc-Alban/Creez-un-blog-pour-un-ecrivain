<?php
declare (strict_types = 1);
namespace Blog\Controller;

use Blog\Model\Frontend\CommentsManager;
use Blog\Model\Frontend\PostManager;
use Blog\View\View;

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
        $View = new View;
        $View->getView('frontend', 'homeView', ['chapters' => $chapters]);
    }

/**
 * Renvoie les chapitres sur la page chapitres
 *
 */
    public function chaptersAction()
    {
        $postManager = new PostManager;
        $chapters = $postManager->getchapters();
        $View = new View;
        $View->getView('frontend', 'chaptersView', ['chapters' => $chapters]);
    }

/**
 * Renvoie les commentaires  et le chapitre sur la page
 */
    public function chapterAction(int $id)
    {
        $postManager = new PostManager;
        $chapter = $postManager->getChapter($id);

        $commentManager = new CommentsManager;
        $comments = $commentManager->getComments($id);
        $View = new View;
        $View->getView('frontend', 'chapterView', ['chapter' => $chapter, 'comments' => $comments]);
    }

    public function signalAction(int $idComment, int $id)
    {
        $commentManager = new CommentsManager;
        $commentManager->signalComment($idComment);

        header('Location: index.php?page=chapter&id=' . $id);
    }

    public function sendCommentAction(array $post, int $id)
    {
        $name = (isset($post['name'])) ? $post['name'] : '';
        $comment = (isset($post['comment'])) ? $post['comment'] : '';
        $errors = [];
        $commentManager = new CommentsManager;
        if (isset($post['submit'])) {
            if (!empty($name) || !empty($comment)) {
                if (!empty($name)) {
                    if (!empty($comment)) {
                        htmlspecialchars(trim($name));
                        htmlspecialchars(trim($comment));
                        if (empty($errors)) {
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
    }

/**
 * Renvoie la page erreur
 */
    public function errorAction()
    {
        $View = new View;
        $View->getView('frontend', 'errorView', null);
    }

}