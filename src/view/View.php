<?php
declare (strict_types = 1);
namespace Blog\View;

class View
{
    private function getUrl(string $statement, string $namePage, ?array $datas)
    {
        require 'templates/' . $statement . '/' . $namePage . '.php';
    }

    private function getHeader(string $statement)
    {
        require 'templates/' . $statement . '/headerView.php';
    }

    private function getFooter(string $statement)
    {
        if (file_exists('footerView.php')) {
            require 'templates/' . $statement . '/footerView.php';
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