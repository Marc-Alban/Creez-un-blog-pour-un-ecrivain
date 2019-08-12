<?php
require_once 'controller/frontend.php';
try {
    if (isset($_GET['page'])) {
        if ($_GET['page'] == 'home') {
            // Page Accueil -- Récupération de chapitre (2)
            getHome();
        } elseif ($_GET['page'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                // Récupération d'un chapitre avec id dans l'url
                getPost($_GET['id']);
                // Récupération des commentaires d'un chapitre avec id passé dans l'url
                getComment($_GET['id']);
                if (isset($_POST) && isset($_POST['envoie'])) {
                    $name = htmlspecialchars(trim($_POST['pseudo']));
                    $comment = htmlspecialchars(trim($_POST['comment']));
                    $errors = [];
                    if (!empty($name) || !empty($comment)) {
                        if (empty($errors)) {
                            comment($name, $comment, $id);
                        }
                    } else {
                        $errors = 'Tous les champs sont vides';
                    }
                }
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['page'] == 'chapitres') {
            // Affichage des chapitres
            listPosts();
        } elseif ($_GET['page'] == 'error' || $_GET['page'] != $page) {
            // Renvoie vers la page Error
            getError();
        }
    } else {
        // Page Accueil
        getHome();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}