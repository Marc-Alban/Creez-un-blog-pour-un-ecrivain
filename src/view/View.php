<?php
declare (strict_types = 1);
namespace Blog\View;

class View
{
    private function getUrl(string $statement, string $namePage, ?array $datas)
    {
        require_once '../templates/' . $statement . '/' . $namePage . '.php';
    }

    private function getHeader(string $statement)
    {
        require_once '../templates/' . $statement . '/headerView.php';
    }

    private function getFooter(string $statement)
    {
        if (file_exists('footerView.php')) {
            require_once '../templates/' . $statement . '/footerView.php';
        }
    }

    public function getView(string $statement, string $namePage, ?array $datas)
    {
        ob_start();
        $this->getHeader($statement);
        $this->getUrl($statement, $namePage, $datas);
        $this->getFooter($statement);
        $content = ob_get_clean();
        require_once '../templates/' . $statement . '/template.php';
    }
}