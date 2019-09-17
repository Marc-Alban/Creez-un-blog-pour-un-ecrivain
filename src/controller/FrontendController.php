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
 * @return void
 */
    public function homeAction(): void
    {
        $postManager = new PostManager();
        $chapters = $postManager->getLimitedChapters();
        $view = new View;
        $view->getView('frontend', 'homeView', ['chapters' => $chapters, 'title' => 'Accueil']);
    }

/**
 * Renvoie les chapitres sur la page chapitres
 *
 * @return void
 */
    public function chaptersAction(): void
    {
        $postManager = new PostManager();
        $chapters = $postManager->getchapters();
        $view = new View;
        $view->getView('frontend', 'chaptersView', ['chapters' => $chapters, 'title' => 'Listes des chapitres']);
    }

/**
 * Renvoie les commentaires et le chapitre
 *
 * @param integer $id
 * @return void
 */
    public function chapterAction(int $id): void
    {
        $postManager = new PostManager();
        $chapter = $postManager->getChapter($id);

        $commentManager = new CommentsManager();
        $comments = $commentManager->getComments($id);
        $view = new View;
        $view->getView('frontend', 'chapterView', ['chapter' => $chapter, 'comments' => $comments, 'title' => 'Chapitre']);
    }

    /**
     * Permet de signaler un commentaire
     *
     * @param integer $idComment
     * @param integer $id
     * @return void
     */
    public function signalAction(int $idComment, int $id): void
    {
        $commentManager = new CommentsManager();
        $commentManager->signalComment($idComment);

        header('Location: index.php?page=chapter&id=' . $id);
    }

    /**
     * Permet d'envoyer un commentaire
     *
     * @param array $post
     * @param integer $id
     * @return void
     */
    public function sendCommentAction(array $post, int $id): void
    {
        $name = (isset($post['name'])) ? $post['name'] : null;
        $comment = (isset($post['comment'])) ? $post['comment'] : null;
        $errors = [];
        $commentManager = new CommentsManager();
        if (!empty($name) || !empty($comment)) {
            htmlspecialchars(trim($name));
            htmlspecialchars(trim($comment));
            if (empty($errors)) {
                $commentManager->setComment($name, $comment, $id);
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
    public function errorAction(): void
    {
        $view = new View();
        $view->getView('frontend', 'errorView', null);
    }

}