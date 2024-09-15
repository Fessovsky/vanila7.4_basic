<?php

namespace Components\Pages;

use Components\Contracts\PageInterface;

final class Notify implements PageInterface
{

    function getHtml()
    {
        return <<<HTML
        <main>
            <div class="container">
                {$this->getContent()}
            </div>
        </main>
HTML;
    }

    function getContent()
    {
        return <<<CONTENT
        <header>
            <h1>Send something to all users</h1>
            <form action="/notify" method="post">
                <input type="text" name="message" placeholder="Message">
                <input type="submit">
            </form>
CONTENT;
    }
}