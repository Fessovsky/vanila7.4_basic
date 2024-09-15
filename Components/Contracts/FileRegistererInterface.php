<?php

namespace Components\Contracts;

interface FileRegistererInterface
{
    public function register($fileName, $checkSum, $filePath): void;
}