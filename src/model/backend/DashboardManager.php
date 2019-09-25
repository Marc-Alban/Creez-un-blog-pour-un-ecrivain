<?php
declare (strict_types = 1);
namespace Blog\Model\Backend;

use Blog\Model\Database;

class DashboardManager
{

    /**
     * Retourne le mot de passe
     *
     * @return string
     */
    public function getUsers(): string
    {
        $query = Database::getDb()->query("SELECT name FROM admins WHERE id = '1'");
        $req = $query->fetch();
        return $req['name'];
    }

/**
 * Retourne le mot de passe
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

    public function userReplace($pseudo)
    {
        $e = [
            ':name' => $pseudo,
        ];
        $sql = "UPDATE admins SET name = :name";
        $query = Database::getDb()->prepare($sql);
        $query->execute($e);

    }

    public function passReplace($password)
    {
        $e = [
            ':pass' => $password,
        ];
        $sql = "UPDATE admins SET password_admin = :pass";
        $query = Database::getDb()->prepare($sql);
        $query->execute($e);
    }

/**
 * Permet la déconnexion de l'utilisateur
 * Supprime la session en court
 *
 * @return void
 */
    public function logoutUser(): void
    {
        session_destroy();
    }

}