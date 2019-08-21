<?php

namespace Openclassroom\Blog\Model;

class ViewPage
{

    public function __construct($statement, $namePage)
    {
        ob_start();
        $this->getHeader($statement);
        $this->getUrl($statement, $namePage);
        $this->getFooter($statement);
        return $content = ob_get_clean();
    }

    private function getUrl($statement, $namePage)
    {
        return 'view/' . $statement . '/' . $namePage . '.php';
    }

    private function getheader($statement)
    {
        require 'view/' . $statement . '/headerView.php';
    }

    private function getfooter($statement)
    {
        require 'view/' . $statement . '/footerView.php';
    }
}