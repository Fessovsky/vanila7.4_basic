<?php

namespace Components\Contracts;

interface FileUploaderInterface
{
    public function upload(array $file): void;
}