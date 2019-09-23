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
 * @param [type] $session
 * @return void
 */
    public function homeAction(&$session): void
    {
        $postManager = new PostManager();
        $chapters = $postManager->getLimitedChapters();
        $oldChapter = $postManager->oldLimitedChapter();
        $view = new View;
        $view->getView('frontend', 'homeView', ['chapters' => $chapters, 'oldChapter' => $oldChapter, 'title' => 'Accueil', 'session' => $session]);
    }

/**
 * Renvoie les chapitres sur la page chapitres
 *
 * @param [type] $session
 * @return void
 */
    public function chaptersAction(&$session): void
    {
        $postManager = new PostManager();
        $chapters = $postManager->getchapters();
        $view = new View;
        $view->getView('frontend', 'chaptersView', ['chapters' => $chapters, 'title' => 'Listes des chapitres', 'session' => $session]);
    }

/**
 * Renvoie les commentaires et le chapitre
 *
 * @param array $getData
 * @param [type] $session
 * @return void
 */
    public function chapterAction(array $getData, &$session): void
    {
        $postManager = new PostManager();
        $chapter = $postManager->getChapter((int) $getData['id']);

        $commentManager = new CommentsManager();
        $comments = $commentManager->getComments((int) $getData['id']);

        $view = new View;
        $view->getView('frontend', 'chapterView', ['chapter' => $chapter, 'comments' => $comments, 'title' => 'Chapitre', 'session' => $session]);
    }

/**
 * Permet de signaler un commentaire
 *
 * @param array $getData
 * @return void
 */
    public function signalCommentAction(array $getData): void
    {
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
 * @param [type] $session
 * @return void
 */
    public function errorAction(&$session): void
    {
        $view = new View();
        $view->getView('frontend', 'errorView', ['session' => $session]);
    }
}