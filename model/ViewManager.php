<?php
declare (strict_types = 1);
namespace Openclassroom\Blog\Model;

class ViewManager
{
    private function getUrl(string $statement, string $namePage, ?array $datas)
    {
        require 'view/' . $statement . '/' . $namePage . '.php';
    }

    private function getHeader(string $statement)
    {
        require 'view/' . $statement . '/headerView.php';
    }

    private function getFooter(string $statement)
    {
        if (file_exists('footerView.php')) {
            require 'view/' . $statement . '/footerView.php';
        }
    }

    public function getView(string $statement, string $namePage, ?array $datas)
    {
        ob_start();
        $this->getHeader($statement);
        $content = $this->getUrl($statement, $namePage, $datas);
        $this->getFooter($statement);

        return ob_get_clean();
    }
}