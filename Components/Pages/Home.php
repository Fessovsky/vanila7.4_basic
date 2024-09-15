<?php

namespace Components\Pages;

use Components\Contracts\PageInterface;

final class Home implements PageInterface
{
    public function getHtml(): string
    {
        return <<<HTML
        <main>
            <div class="container">
                {$this->getContent()}
            </div>
        </main>
        HTML;
    }

    public function getContent(): string
    {
        return <<<CONTENT
        <header>
            <h1>Welcome to the Home Page</h1>
        </header>
        <p>This is demo application made without frameworks, composer, or any other dependencies.</p>
        <h4>Links</h4>
        <ul>
            <li><a href="/upload">Upload</a></li>
        </ul>
CONTENT;

    }
}