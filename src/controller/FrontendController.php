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
 * et signale les commentaires
 *
 * @param array $getData
 * @param [type] $session
 * @return void
 */
    public function chapterAction(array $getData, &$session): void
    {
        $id = (int) $getData['get']['id'];
        $name = $getData['post']['name'] ?? null;
        $comment = $getData['post']['comment'] ?? null;
        $action = $getData['get']['action'] ?? null;
        $errors = $session['errors'] ?? null;
        unset($session['errors']);
        $postManager = new PostManager();
        $chapter = $postManager->getChapter($id);

        $commentManager = new CommentsManager();
        $comments = $commentManager->getComments($id);

        if ($action === 'signalComment') {
            $commentManager->signalComment((int) $getData['get']['idComment']);
        }

        if ($action === 'submitComment') {
            if (!empty($name) || !empty($comment)) {
                if (!empty($name)) {
                    if (!empty($comment)) {
                        htmlspecialchars(trim($name));
                        htmlspecialchars(trim($comment));
                        $commentManager->setComment($name, $comment, $id);
                    } else {
                        $errors['name'] = "Veuillez renseigner une description";
                    }
                } else {
                    $errors['comment'] = "Veuillez mettre un pseudo";
                }
            } else {
                $errors["Champs"] = "Veuillez remplir les champs";
            }
        }

        $view = new View;
        $view->getView('frontend', 'chapterView', ['chapter' => $chapter, 'comments' => $comments, 'title' => 'Chapitre', 'session' => $session, 'errors' => $errors]);
    }

/**
 * Renvoie la page erreur
 *
 * @param [type] $session
 * @return void
 */
    public function errorAction(): void
    {
        $view = new View();
        $view->getView('frontend', 'errorView', null);
    }
}