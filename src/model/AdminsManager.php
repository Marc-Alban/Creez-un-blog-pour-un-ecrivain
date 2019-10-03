<?php
declare (strict_types = 1);
namespace Blog\Model;

use Blog\Model\Database;

class AdminsManager
{

    /**
     * Retourne le mot de passe
     *
     * @return string
     */
    public function getUsers(string $pseudo): ?string
    {
        $query = Database::getDb()->prepare("SELECT name FROM admins WHERE name = :pseudo ");
        $query->execute(array(':pseudo' => $pseudo));
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

    public function userReplace(string $pseudo): void
    {
        $e = [
            ':name' => $pseudo,
        ];
        $sql = "UPDATE admins SET name = :name";
        $query = Database::getDb()->prepare($sql);
        $query->execute($e);

    }

    /**
     * Undocumented functionRemplace le mot de pass en bdd
     *
     * @param integer $password
     * @return void
     */
    public function passReplace(string $password): void
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