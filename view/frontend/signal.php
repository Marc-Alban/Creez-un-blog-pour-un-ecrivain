<?php

if (isset($_GET['id']) && isset($_SESSION['pass'])) {
    $bdd->exec("UPDATE comments SET seen = '1' WHERE id = {$_GET['id']}");
    header('Location: index.php?page=home');
}