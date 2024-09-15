<?php

namespace Components\Controllers;

use Components\Contracts\ControllerInterface;
use Components\Contracts\PageInterface;
use Components\Contracts\RenderInterface;
use Components\Pages\Home;
use Components\Utils\RenderHTML;

class HomeController implements ControllerInterface
{

    private RenderInterface $renderer;
    private PageInterface $page;
    public function __construct()
    {
        $this->page = new Home();
        $this->renderer = new RenderHTML();
    }

    public function index(): void
    {
        $this->renderer->render($this->page->getHtml());
    }
}