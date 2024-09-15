<?php

namespace Components\Pages;

use Components\Contracts\Contracts\PageInterface;

final class Upload implements PageInterface
{
    public function getContent(): string
    {
        return <<<HTML
        <form action="/upload" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <input type="submit">
        </form>
        HTML;
    }
}