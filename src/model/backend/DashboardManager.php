<?php
declare (strict_types = 1);
namespace Blog\Model\Backend;

use Blog\Model\Database;

class DashboardDatabase
{

/**
 * Retourne true si utilisateur en bdd ou false si utilisateur non présent
 *
 * @return string
 */
    public function getPass(): string
    {
        $query = Database::getDb()->query("SELECT password_admin FROM admins");
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
    }

}