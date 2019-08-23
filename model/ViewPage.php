<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model;

class ViewPage
{
    private function getUrl($statement, $namePage)
    {
        require 'view/' . $statement . '/' . $namePage . '.php';
    }

    private function getheader($statement)
    {
        require 'view/' . $statement . '/headerView.php';
    }

    private function getfooter($statement)
    {
        if (file_exists('footerView.php')) {
            require 'view/' . $statement . '/footerView.php';
        }
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