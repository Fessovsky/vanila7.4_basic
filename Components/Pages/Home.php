<?php

namespace Components\Pages;

use Components\Contracts\Contracts\PageInterface;

final class Home implements PageInterface
{
    public function getContent(): string
    {
        return <<<HTML
        <style>
            html {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                background-color: #f4f4f4;
                padding: 20px;
            }
            h1 {
                color: #333;
                font-family: Arial, sans-serif;
            }
            ul {
                list-style-type: none;
                padding: 0;
            }
            li {
                display: inline;
                margin-right: 10px;
            }
            a {
                /*text-decoration: none;*/
                color: #333;
            }
        </style>
        <h1>Welcome to the Home Page</h1>
        <p>This is demo application made without frameworks, composer, or any other dependencies.</p>
        <h4>Links</h4>
        <ul>
            <li><a href="/upload">Upload</a></li>
        </ul>
        HTML;
    }
    public function getTitle(): string
    {
        return 'Home';
    }
}