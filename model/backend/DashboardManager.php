<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model\Backend;

use Openclassroom\Blog\Model\Manager;

require_once 'model/Manager.php';

class DashboardManager extends Manager
{

    /**
     * Retourne true si utilisateur en bdd ou false si utilisateur non présent
     */
    public function isAdmin()
    {
        $query = $this->dbConnect()->query("SELECT password_admin FROM admins");
        $req = $query->fetch();
        $pass = $req[0];
        return $pass;
    }

    /**
     * Permet la déconnexion de l'utilisateur
     * Supprime la session en court
     *
     * @param string $user
     */
    public function logoutUser()
    {
        session_destroy();
        header("Location: index.php?page=home");
    }

}