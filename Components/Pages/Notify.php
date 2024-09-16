<?php

namespace Components\Pages;

use Components\Contracts\PageInterface;

final class Notify extends AbstractPage implements PageInterface
{
    public function getContent(): string
    {
        return <<<CONTENT
        <header>
            <h1>Send something to all users</h1>
            <form action="/notify" method="post">
                <input type="text" name="Subject" placeholder="Subject">
                <input type="text" name="message" placeholder="Message">
                <input type="submit">
            </form>
CONTENT;
    }
}