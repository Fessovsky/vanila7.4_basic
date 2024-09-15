<?php

namespace Components\Pages;

use Components\Contracts\PageInterface;

final class Upload implements PageInterface
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
            <h1>Upload valid CSV with users</h1>
        </header>
        <h4>Instructions</h4>
        <p>Upload a CSV file with the following fields:</p>
        <table style='border:1px solid #ccc;font-size: 0.9em; margin:1em 0'>
            <tr>
                <th>Field name</th>
                <th>Type</th>
            </tr>
            <tr>
                <td>id</td>
                <td><i>int</i></td>
            </tr>
            <tr>
                <td>name</td>
                <td><i>string</i></td>
            </tr>
        </table>
        <form action="/upload" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <input type="submit">
        </form>
CONTENT;
    }
}