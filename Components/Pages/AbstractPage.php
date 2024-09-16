<?php

namespace Components\Pages;

abstract class AbstractPage
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
        <p>No content yet</p>
        CONTENT;
    }
}