<?php
//Démarage session
session_start();
// Demande les différents controllers
require_once 'controller/frontend.php';
require_once 'controller/backend.php';
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
            getHome();

            //Page post
        } elseif ($_GET['page'] == 'post') {
            //Test si identifiant dans l'url
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                //Test si un envoie à eu lieu
                if (isset($_POST) && isset($_POST['envoie'])) {

                    $name = htmlspecialchars(trim($_POST['name']));
                    $comment = htmlspecialchars(trim($_POST['comment']));
                    $errors = [];

                    //Vérification des champs vides
                    if (!empty($name) || !empty($comment)) {
                        //Vérification des érreurs
                        if (empty($errors)) {
                            //Insertion d'un commentaire en bdd
                            instComment($name, $comment, $_GET['id']);
                            //Redirection sur la même page afin d'actualiser
                            header('Location: index.php?page=post&id=' . $_GET['id']);
                        }
                    } else {
                        $errors = 'Tous les champs sont vides';
                    }
                }
                //Test si il y a le mot page, l'identifiant ainsi que comment_id
                if ($_GET['page'] === 'post' && $_GET['id'] && isset($_GET['comment_id']) && $_GET['comment_id']) {
                    //signale le commentaire
                    signalComment($_GET['comment_id']);
                }

                // Récupération de la vue d'un chapitre avec son id dans l'url et ses commentaires
                requireView($_GET['id']);

            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }

            //Page chapitres
        } elseif ($_GET['page'] == 'chapitres') {
            //Renvoie la page vue des chapitres
            listPosts();

            //Page error ---> a modifier en fonction de ce que marque l'utilisateur dans l'url
        } elseif ($_GET['page'] == 'error') {
            //Renvoie la page vue de Error
            getError();

            //----------------------------------------------------Backend-------------------------------------//

            //Page login
        } elseif ($_GET['page'] == 'login') {
            //Si pas de session avec un mot de passe
            if (!isset($_SESSION['pass'])) {
                //Renvoie la page vue de login
                getLogin();
                //Test si il y a un envoie
                if (isset($_POST['submit'])) {
                    //insertion du mot de passe envoyé dans une variable
                    $password = htmlspecialchars(trim($_POST['password']));
                    //si champs vide
                    if (empty($password)) {
                        throw new Exception('Champs n\'est pas remplis !');
                        //Vérification du mot de passe envoyé avec celui en bdd
                    } else if (password_verify($password, getUser())) {
                        //Insertion du mot de passe en Session
                        ob_start();
                        $_SESSION['pass'] = getUser();
                        $user = ob_get_contents();
                        //Renvoie sur le dashboard
                        header('Location: index.php?page=dashboard');
                    } else {
                        throw new Exception('Ce mot de passe n\'est pas bon pas !');
                    }
                }
            } else {
                //Si il y a déjà un  mot de passe, renvoie sur le dashboard
                header('Location: index.php?page=dashboard');
            }
            //Page dashboard
        } else if ($_GET['page'] == 'dashboard') {
            //Si Session
            if (isset($user)) {
                //Si mot dans l'url /val
                if (isset($_GET['/val'])) {
                    //Valide le commentaire
                    validateComment($_GET['id']);
                    //Si mot /del
                } else if (isset($_GET['/del'])) {
                    //Supprime le commentaire
                    deleteComment($_GET['id']);
                }
                //Renvoie la page vue du dashboard
                getDashboard();
            }
            //Page chapitre -- dashboard
        } else if ($_GET['page'] == 'list') {
            //Si Session existe
            if (isset($user)) {
                //Renvoie la page vue des chapitres dans le dashboard
                getList();
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
                        $posted = (isset($_POST['public']) == 'on') ? "1" : "0";
                        $file = $_FILES['image']['name'];
                        $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
                        $extention = strrchr($file, '.');
                        $errors = [];

                        //Vérification des champs vides
                        if (!empty($title) || !empty($content)) {
                            //Vérification du champs vide title
                            if (!empty($title)) {
                                //Vérification du champs vide content
                                if (!empty($content)) {
                                    //Vérification de l'extention par rapport au tableau extention(s) ou bien à l'extention .png
                                    if (in_array($extention, $extentions) || $extention = ".png") {
                                        //Mise à jour du chapitre
                                        updatePost($_FILES['image']['tmp_name'], $extention, $title, $content, $posted, $_GET['id']);
                                    } else {
                                        throw new Exception('Image n\'est pas valide! ');
                                    }
                                } else {
                                    throw new Exception('Veuillez mettre un contenu !');
                                }
                            } else {
                                throw new Exception('Veuillez mettre un titre !');
                            }
                        } else {
                            throw new Exception('Veuillez remplir tous les champs !');
                        }
                    }
                    //Récupère un post en fonction de l'id
                    getPostEdit($_GET['id']);
                } else {
                    throw new Exception('Aucun identifiant envoyé !');
                }
            }
            //Page ecriture d'un chapitre
        } else if ($_GET['page'] == 'write') {
            // Si session
            if (isset($user)) {
                //test envoie
                if (isset($_POST['submit'])) {

                    $title = htmlspecialchars(trim($_POST['title']));
                    $content = htmlspecialchars(trim($_POST['description']));
                    $posted = ($_POST['public'] == 1) ? "1" : "0";
                    $name = 'Jean';
                    $errors = [];
                    //Test si champs vide
                    if (!empty($title) || !empty($content)) {
                        //test champs vide title
                        if (!empty($title)) {
                            //test champs vide content
                            if (!empty($content)) {

                                $file = $_FILES['image']['name'];
                                $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
                                $extention = strrchr($file, '.');
                                //test extention(s): pour  savoir si l'extention correspon aux extention dans le tableau
                                if (in_array($extention, $extentions)) {
                                    //test champs vide name
                                    if (!empty($name)) {
                                        //Insertion du chapitre en bdd
                                        PostWrite($title, $content, $name, $posted, $_FILES['image']['tmp_name'], $extention);
                                    } else {
                                        throw new Exception('Nom manquant !');
                                    }
                                } else {
                                    throw new Exception('Image n\'est pas valide! ');
                                }
                            } else {
                                throw new Exception('Veuillez renseigner du contenu ! ');
                            }
                        } else {
                            throw new Exception('Veuillez renseigner un titre !');
                        }
                    } else {
                        throw new Exception('Veuillez remplir les champs');
                    }
                }
                //Renvoie la page vue d'écriture d'un chapitre
                getWrite();
            }
        }
        //Test du chemin absolue si seulement index.php sans de page dans l'url
    } else if ($cheminRemplacer === $cheminLocal) {
        //Renvoie la page vue  Accueil
        getHome();
    } else {
        // Page Erreur
        getError();
    }
    //Renvoie les erreurs si faux !
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}