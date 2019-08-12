<?php
session_start();
require_once 'controller/frontend.php';
require_once 'controller/backend.php';
try {
    if (isset($_GET['page'])) {
        //----------------------------------------------------Frontend-------------------------------------//
        // Page Accueil --
        if ($_GET['page'] == 'home') {
            getHome();
            //Page Post
        } elseif ($_GET['page'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                // Récupération d'un chapitre avec id dans l'url avec commentaire ou pas
                requireView($_GET['id']);

                if (isset($_POST) && isset($_POST['envoie'])) {
                    $name = htmlspecialchars(trim($_POST['name']));
                    $comment = htmlspecialchars(trim($_POST['comment']));
                    $errors = [];
                    if (!empty($name) || !empty($comment)) {
                        if (empty($errors)) {
                            //Insertion d'un commentaire en bdd
                            instComment($name, $comment, $_GET['id']);

                        }
                    } else {
                        $errors = 'Tous les champs sont vides';
                    }
                }
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
            //Si récupère page chapitres
        } elseif ($_GET['page'] == 'chapitres') {
            // Affichage des chapitres
            listPosts();
            //Si récupère page error
        } elseif ($_GET['page'] == 'error') {
            // Renvoie vers la page Error
            getError();
            //----------------------------------------------------Backend-------------------------------------//
            //Si récupère page login
        } elseif ($_GET['page'] == 'login') {
            //Renvoie la page Login du dashboard
            if (!isset($_SESSION['pass'])) {
                getLogin();
                if (isset($_POST['submit'])) {
                    $password = htmlspecialchars(trim($_POST['password']));
                    if (empty($password)) {
                        throw new Exception('Champs n\'est pas remplis !');
                    } else if (password_verify($password, getUser())) {
                        $_SESSION['pass'] = getUser();
                        header('Location: index.php?page=dashboard');
                    } else {
                        throw new Exception('Ce mot de passe n\'est pas bon pas !');
                    }
                }
            } else {
                header('Location: index.php?page=dashboard');
            }
        } else if ($_GET['page'] == 'dashboard') {
            if (isset($_SESSION['pass'])) {
                getDashboard();
            }
        } else if ($_GET['page'] == 'list') {
            if (isset($_SESSION['pass'])) {
                getList();
            }
        } else if ($_GET['page'] == 'postEdit') {
            if (isset($_SESSION['pass'])) {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (isset($_POST['submit'])) {
                        $title = htmlspecialchars(trim($_POST['title']));
                        $content = htmlspecialchars(trim($_POST['content']));
                        $posted = (isset($_POST['public']) == 'on') ? "1" : "0";
                        // $errors = [];
                        if (!empty($title) || !empty($content)) {
                            if (!empty($title)) {
                                if (!empty($content)) {
                                    updatePost($title, $content, $posted, $_GET['id']);
                                    header('Location: index.php?page=postEdit&id=' . $_GET['id']);
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

                } else {
                    throw new Exception('Aucun identifiant envoyé !');
                }
                getPostEdit($_GET['id']);
            }
        } else if ($_GET['page'] == 'write') {
            if (isset($_SESSION['pass'])) {
                getWrite();
                if (isset($_POST['submit'])) {
                    $title = htmlspecialchars(trim($_POST['title']));
                    $content = htmlspecialchars(trim($_POST['description']));
                    $posted = ($_POST['public'] == 1) ? "1" : "0";
                    $name = 'Jean';
                    //Erreur comment les afficher dans un tableau  voir avec prof !?
                    //$errors = [];
                    if (!empty($title) || !empty($content)) {
                        if (!empty($title)) {
                            if (!empty($content)) {
                                $file = $_FILES['image']['name'];
                                $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
                                $extention = strrchr($file, '.');
                                if (!in_array($extention, $extentions) || $extentions = ".png") {
                                    if (!empty($name)) {
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
            }
        }
    } else {
        // Page Accueil
        getHome();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}