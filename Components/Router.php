<?php

namespace Components;

use Components\Pages\Home;
use Components\Pages\Upload;

final class Router
{
    private $url;
    private $page;
    public function __construct()
    {
        $this->url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        if (preg_match('/^\/[a-zA-Z0-9\/\-]*$/', $this->url)) {
            switch ($this->url) {
                case '/upload':
                    $this->page = new Upload();
                    break;
                default:
                    $this->page = new Home();
            }
        } else {
            header('HTTP/2.0 400 Bad Request');
            exit('Некорректный запрос.');
        }
    }

    public function router() {
//        var_dump($this->page);
        echo $this->page->getContent();
    }
}