<?php
namespace Openclassroom\Blog\Model\Backend;

use Openclassroom\Blog\Model\Manager;

require_once 'model/Manager.php';

class DashboardManager extends Manager
{

    public function isAdmin()
    {
        $query = $this->dbConnect()->query("SELECT password_admin FROM admins");
        $req = $query->fetch();
        $pass = $req[0];
        return $pass;
    }

    public function logoutUser($user)
    {
        unset($user);

        header("Location: index.php?page=home");
    }

}