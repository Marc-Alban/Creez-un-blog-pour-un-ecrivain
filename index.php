<?php
declare (strict_types = 1);
//Démarage session
session_start();
// Demande les différents controllers
require_once 'controller/FrontendController.php';
require_once 'controller/BackendController.php';
//Instance de l'objet
$front = new FrontendController;
$back = new BackendController;
//Chemin absolue
$serveurChemin = $_SERVER['SCRIPT_FILENAME'];
$cheminLocal = realpath('index.php');
$cheminRemplacer = str_replace("/", "\\", $serveurChemin);
//Essaie:: url pour avoir la page correspondante
try {
    //Si dans l'url il y a le mot page alors :
    if (isset($_GET['page'])) {
        //----------------------------------------------------Frontend-------------------------------------//
        // Page Accueil --
        if ($_GET['page'] == 'home') {
            //Renvoie la page vue de l'accueil
            $front->getHomeViewAction();
            //Page post
        } elseif ($_GET['page'] == 'post') {
            //Test si identifiant dans l'url
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                    $id = intval($_GET['id']);
                    $idComment = intval($_GET['comment_id']);
                    $front->chapitreViewAction('', '', $id, $idComment);
                } else if (isset($_POST) && isset($_POST['envoie'])) {
                    $id = intval($_GET['id']);
                    $name = $_POST['name'];
                    $content = $_POST['comment'];
                    $front->chapitreViewAction($name, $content, $id);
                } else {
                    $id = intval($_GET['id']);
                    $front->chapitreViewAction('', '', $id);
                }

            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }

            //Page chapitres
        } elseif ($_GET['page'] == 'chapitres') {
            //Renvoie la page vue des chapitres
            $front->ChapitresAction();
            //Page logout
        } elseif ($_GET['page'] == 'logout') {
            //Fonction déconnexion
            $back->logoutAction();

            //Page error ---> a modifier en fonction de ce que marque l'utilisateur dans l'url
        } elseif ($_GET['page'] == 'error' || $_GET['page'] == '' || !isset($_GET['page'])) {
            //Renvoie la page vue de Error
            $front->getErrorAction();
            //----------------------------------------------------Backend-------------------------------------//
            //Page login
        } elseif ($_GET['page'] == 'login') {

            //Si pas de session avec un mot de passe
            if (!isset($_SESSION['pass'])) {
                //Test si il y a un envoie
                if (isset($_POST['submit'])) {
                    //Renvoie la page vue de login
                    $_SESSION['pass'] = $back->getLoginViewAction($_POST['password']);
                    header('Location: index.php?page=dashboard');
                } else {
                    $back->getLoginViewAction();
                }
            } else {
                //Si il y a déjà un  mot de passe, renvoie sur le dashboard
                header('Location: index.php?page=dashboard');
            }

            //Page dashboard
        } else if ($_GET['page'] == 'dashboard') {

            //Si Session
            if (isset($_SESSION['pass'])) {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    //Recupération de l'id
                    $idRecup = $_GET['id'];
                    //fonction qui transforme la chaine en integer
                    $id = intval($idRecup);
                }

                //Si mot dans l'url /val
                if (isset($_GET['/val'])) {
                    $action = 1;
                    //Valide le commentaire
                    $back->getDashboardAction($id, $action);
                } else if (isset($_GET['/del'])) {
                    $action = 0;
                    //Supprime le commentaire
                    $back->getDashboardAction($id, $action);
                }

                //Renvoie la page vue du dashboard
                $back->getDashboardAction();
            } else {
                header('Location: index.php?page=login');
            }
            //Page chapitre -- dashboard
        } else if ($_GET['page'] == 'list') {
            //Si Session existe
            if (isset($_SESSION['pass'])) {
                //Renvoie la page vue des chapitres dans le dashboard
                $back->getChapitresAction();
            } else {
                header('Location: index.php?page=login');
            }
            //Page MAJ chapitre
        } else if ($_GET['page'] == 'postEdit') {
            //Si Session
            if (isset($_SESSION['pass'])) {
                //Si identifiant
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    //Test si il y a un envoie
                    if (isset($_POST['modified'])) {
                        $title = htmlspecialchars(trim($_POST['title']));
                        $content = htmlspecialchars(trim($_POST['content']));
                        $posted = (isset($_POST['public']) == 'on') ? 1 : 0;
                        $tmp_name = $_FILES['image']['tmp_name'];
                        $file = $_FILES['image']['name'];
                        $id = inval($_GET['id']);
                        ($_GET['action']) ? $action = intval($_GET['action']) : '';

                        if ($action == 1) {
                            $back->getChapitreEditAction($id, $title, $content, $tmp_name, $posted, $action, $file);
                        }

                    } else if (isset($_POST['deleted'])) {
                        $id = intval($_GET['id']);
                        $posted = (isset($_POST['public']) == 'on') ? 1 : 0;

                        if ($action == 2) {
                            $back->getChapitreEditAction($id, '', '', '', $posted, $action, '');
                        }

                    } else {
                        $id = intval($_GET['id']);
                        $posted = (isset($_POST['public']) == 'on') ? 1 : 0;
                        $back->getChapitreEditAction($id, '', '', '', $posted, $action, '');
                    }
                } else {
                    throw new Exception('Aucun identifiant envoyé !');
                }
            } else {
                header('Location: index.php?page=login');
            }
            //Page ecriture d'un chapitre
        } else if ($_GET['page'] == 'write') {
            // Si session
            if (isset($_SESSION['pass'])) {
                //test envoie
                ($_GET['action']) ? $action = intval($_GET['action']) : '';
                if (isset($_POST['submit'])) {

                    $title = htmlspecialchars(trim($_POST['title']));
                    $content = htmlspecialchars(trim($_POST['description']));
                    $posted = (isset($_POST['public']) == 'on') ? 1 : 0;
                    $tmp_name = $_FILES['image']['tmp_name'];
                    $file = $_FILES['image']['name'];

                    if ($action == 1) {
                        $back->getWriteViewAction($title, $content, $posted, $tmp_name, $action, $file);
                    }
                } else {
                    $posted = (isset($_POST['public']) == 'on') ? 1 : 0;
                    //Renvoie la page vue d'écriture d'un chapitre
                    $back->getWriteViewAction('', '', $posted, '', $action, '');
                }
            }
        }

        //---------------------------------------------------------------------------Front-------------------------------------------------//
        //Test du chemin absolue si seulement index.php sans de page dans l'url
    } else if ($cheminRemplacer === $cheminLocal) {
        //Renvoie la page vue  Accueil
        $front->getHomeViewAction();
    } else {
        // Page Erreur
        $front->getErrorAction();
    }
    //Renvoie les erreurs si faux !
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}