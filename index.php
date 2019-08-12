<?php
require_once 'controller/frontend.php';
(isset($_SESSION['pass'])) ? $user = $_SESSION['pass'] : "";
try {
    if (isset($_GET['page'])) {
        // Page Accueil -- Récupération de chapitre (2)
        if ($_GET['page'] == 'home') {
            getHome();
            //Si récupère page post
        } elseif ($_GET['page'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                // Récupération d'un chapitre avec id dans l'url
                getPost($_GET['id']);
                // Récupération des commentaires d'un chapitre avec id passé dans l'url
                getComment($_GET['id']);
                if (isset($_POST) && isset($_POST['envoie'])) {
                    $name = htmlspecialchars(trim($_POST['name']));
                    $comment = htmlspecialchars(trim($_POST['comment']));
                    $errors = [];
                    if (!empty($name) || !empty($comment)) {
                        if (empty($errors)) {
                            comment($name, $comment, $_GET['id']);
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
            //Récupère la page ...
        } //  elseif ($_GET['page'] == '' ) {
        //     // Renvoie vers la page Error

        // }
    } else {
        // Page Accueil
        getHome();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

// login.php

// if (isset($_POST['submit'])) {
//     $password = htmlspecialchars(trim($_POST['password']));
//     $errors = [];

//     if (empty($password)) {
//         $errors['empty'] = "Tous les champs ne sont pas remplis !";
//     } else if (password_verify($_POST['password'], is_admin($password))) {
//         $errors['exists'] = "Ce mot de passe n'est pas bon pas !";
//     }
// else {
//     $_SESSION['pass'] = $password;
//     header('Location: index.php?page=dashboard');
// }
// }
//--------------------------------------------------------------
//--------------------------------------------------------------
// post.php

// $post = get_post();
// if ($post == false) {
//     header("Location: index.php?page=error");
// }
// if (isset($_POST['submit'])) {
//     $title = htmlspecialchars(trim($_POST['title']));
//     $content = htmlspecialchars(trim($_POST['content']));
//     $posted = (isset($_POST['public']) == on) ? "1" : "0";

//     $errors = [];

//     if (!empty($title) || !empty($content)) {
//         if (!empty($title)) {
//             if (!empty($content)) {
//                 edit($title, $content, $posted, $_GET['id']);
//             } else {
//                 $errors['content'] = "Veuillez mettre un contenu !";
// }
//         } else {
//             $errors['title'] = "Veuillez mettre un titre !";
//         }
//     } else {
//         $errors['empty'] = "Veuillez remplir tous les champs !";
//     }
// }

// if (isset($_POST['delete'])) {
//     deletePost();
// }
//--------------------------------------------------------------
//--------------------------------------------------------------

//write.php

// if (isset($_POST['post'])) {
//     $title = htmlspecialchars(trim($_POST['title']));
//     $content = htmlspecialchars(trim($_POST['description']));
//     $posted = ($_POST['public'] == 1) ? "1" : "0";
//     $name = ($_SESSION['pass']) ? 'Jean' : '';
//     $errors = [];

//     if (!empty($title) || !empty($content)) {
//         if (!empty($title)) {
//             if (!empty($content)) {
//                 $file = $_FILES['image']['name'];
//                 $extentions = ['.jpg', '.png', '.gif', '.jpeg', '.JPG', '.PNG', '.GIF', '.JPEG'];
//                 $extention = strrchr($file, '.');

//                 if (!in_array($extention, $extentions) || $extentions = ".png") {
//                     if (!empty($name)) {
//                         post($title, $content, $name, $posted, $_FILES['image']['tmp_name'], $extention);
//                     } else {
//                         $errors['name'] = "Nom manquant ! ";
//                     }
//                 } else {
//                     $errors['image'] = "Image n'est pas valable ! ";
//                 }
//             } else {
//                 $errors['content'] = "Veuillez renseigner du contenu ! ";
//             }
//         } else {
//             $errors['title'] = "Veuillez renseigner un titre !";
//         }
//     } else {
//         $errors['empty'] = "Veuillez remplir les champs";
//     }
// }