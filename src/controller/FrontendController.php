<?php
declare (strict_types = 1);
namespace Blog\Controller;

use Blog\Model\CommentsManager;
use Blog\Model\PostsManager;
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
        $postManager = new PostsManager();
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
        $postManager = new PostsManager();
        $chapters = $postManager->getchapters(1);
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
    public function chapterAction(&$session, array $getData): void
    {

        if ($session['valideToken'] === false) {$errors["token"] = "Formulaire Incorrect";}

        $postManager = new PostsManager();
        $commentManager = new CommentsManager();
        $id = ($getData['get']['id']) ? (int) $getData['get']['id'] : 1;
        $chapter = $postManager->getChapter($id, 2);
        $name = $getData['post']['name'] ?? null;
        $comment = $getData['post']['comment'] ?? null;
        $action = $getData['get']['action'] ?? null;
        $errors = $session['errors'] ?? null;
        unset($session['errors']);

        if ($action === 'signalComment') {
            $commentManager->signalComment((int) $getData['get']['idComment']);
        }

        if ($action === 'submitComment') {
            if (empty($name) && empty($comment)) {
                $errors["Champs"] = "Veuillez remplir les champs obligatoires";
            } else if (empty($name)) {
                $errors['name'] = "Veuillez mettre un pseudo";
            } else if (empty($comment)) {
                $errors['comment'] = "Veuillez renseigner une description";
            } else if (strlen($name) <= 8) {
                $errors['taille'] = "Veuillez mettre un pseudo de 8 caractères minimum ...";
            } else if (!preg_match('/^[^-]([a-zéèàùûêâôë]*[\'\-\s]?[a-zéèàùûêâôë\s]*){1,}[^-]$/i', $name)) {
                $errors['caractere'] = "Veuillez mettre des caractères alphanumérique et non un caractère spéciaux ";
            }

            if (empty($errors)) {
                $name = htmlentities(trim($name));
                $comment = htmlentities(trim($comment));
                $commentManager->setComment($name, $comment, $id);
            }

        }

        $comments = $commentManager->getComments($id);

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