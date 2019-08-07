<?php
require 'controller/frontend.php';
try {
    if (isset($_GET['page'])) {
        if ($_GET['page'] == 'home') {
            getHome();
        } elseif ($_GET['page'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                getPost();
                getComment();
                if (getComment() == false) {
                    getError();
                }
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['page'] == 'error') {
            getError();
        }
    } else {
        getHome();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}