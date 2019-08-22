<?php

namespace Openclassroom\Blog\Model;

class ViewPage
{
    private function getUrl($statement, $namePage)
    {
        require_once 'view/' . $statement . '/' . $namePage . '.php';
    }

    private function getheader($statement)
    {
        require_once 'view/' . $statement . '/headerView.php';
    }

    private function getfooter($statement)
    {
        require_once 'view/' . $statement . '/footerView.php';
    }

    public function getView($statement, $namePage)
    {
        ob_start();
        $this->getHeader($statement);
        $this->getUrl($statement, $namePage);
        $this->getFooter($statement);
        return ob_get_clean();
    }
}