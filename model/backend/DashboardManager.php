<?php
use Openclassroom\Blog\Model\Manager;

class DashboardManager extends Manager
{
    /**
     * Compte le nombre de publications et affiche un nombre
     *
     * @param [type] $table
     * @return void
     */
    public function in_table(int $table)
    {

        $sql = $this->dbConnect()->query("SELECT COUNT(id) FROM $table ");
        return $nombre = $sql->fetch();
    }

    /**
     * Affiche une couleur en fonction du nombre de carré sur le dashboard
     * par défault ce sera rouge
     *
     * @param [type] $table
     * @param [type] $colors
     * @return void
     */
    public function getColor($table, $colors)
    {
        if (isset($colors[$table])) {
            return $colors[$table];
        } else {
            return 'red';
        }

    }

    public function logoutUser($user)
    {
        unset($user);

        header("Location: index.php?page=home");
    }

}