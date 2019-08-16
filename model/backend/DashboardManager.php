<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model\Backend;

use Openclassroom\Blog\Model\Manager;

require_once 'model/Manager.php';

class DashboardManager extends Manager
{

/**
 * Retourne true si utilisateur en bdd ou false si utilisateur non présent
 *
 * @return string
 */
    public function getPass()
    {
        $query = $this->getPDO()->query("SELECT password_admin FROM admins");
        $req = $query->fetch();
        $pass = $req[0];
        return $pass;
    }

/**
 * Permet la déconnexion de l'utilisateur
 * Supprime la session en court
 *
 * @return void
 */
    public function logoutUser()
    {
        session_destroy();
        header("Location: index.php?page=home");
    }

}