<?php

namespace Components\Utils;

use Components\Contracts\RenderInterface;

final class RenderHTML implements RenderInterface
{
    function render($data): void
    {
        echo $data;
    }
}