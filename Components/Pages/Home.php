<?php

namespace Components\Pages;

use Components\Contracts\PageInterface;

final class Home extends AbstractPage implements PageInterface
{
    public function getContent(): string
    {
        return <<<CONTENT
        <header>
            <h1>Welcome to the Home Page</h1>
        </header>
        <p>This is demo application made without frameworks, composer, or any other dependencies.</p>
CONTENT;
    }
}