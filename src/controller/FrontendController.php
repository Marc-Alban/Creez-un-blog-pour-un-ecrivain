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
        $oldChapter = $postManager->oldLimitedChapter();
        $view = new View;
        $view->getView('frontend', 'homeView', ['chapters' => $chapters, 'oldChapter' => $oldChapter, 'title' => 'Accueil']);
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
 * @param array $getData
 * @return void
 */
    public function chapterAction(array $getData): void
    {
        $postManager = new PostManager();
        $chapter = $postManager->getChapter((int) $getData['id']);

        $commentManager = new CommentsManager();
        $comments = $commentManager->getComments((int) $getData['id']);

        $view = new View;
        $view->getView('frontend', 'chapterView', ['chapter' => $chapter, 'comments' => $comments, 'title' => 'Chapitre']);
    }

/**
 * Permet de signaler un commentaire
 *
 * @param array $getData
 * @return void
 */
    public function signalCommentAction(array $getData): void
    {
        // var_dump($getData);
        // die();
        $commentManager = new CommentsManager();
        $commentManager->signalComment((int) $getData['get']['idComment']);
    }

/**
 * Permet d'envoyer un commentaire
 *
 * @param array $getData
 * @return void
 */
    public function submitCommentAction(array $getData): void
    {
        $name = $getData['post']['name'];
        $comment = $getData['post']['comment'];
        $id = (int) $getData['get']['id'];
        $commentManager = new CommentsManager();
        if (!empty($name) || !empty($comment)) {
            htmlspecialchars(trim($name));
            htmlspecialchars(trim($comment));
            $commentManager->setComment($name, $comment, $id);
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