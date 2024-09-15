<?php

namespace Components\Services;

use Components\Contracts\FileUploaderInterface;

final class CsvFileUploader implements FileUploaderInterface
{
    const MAX_FILE_SIZE = 5 * 1024 * 1024; // Mb
    private string $uploadDir;
    private string $newFileName = '';
    private string $uploadPath = '';
    private string $checkSum = '';

    public function __construct(string $uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    public function upload(array $file): void
    {
        $file = $file['file'];
        if ($file['size'] > self::MAX_FILE_SIZE ) {
            throw new \Exception('File is too large');
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('Upload error');
        }

        $mimes = ['application/vnd.ms-excel','text/plain','text/csv','text/tsv'];
        if (!in_array($_FILES['file']['type'], $mimes)) {
            die("Sorry, mime type not allowed");
        }

        $this->newFileName = uniqid('csv_', true) . '.csv';
        $this->uploadPath = $this->uploadDir . DIRECTORY_SEPARATOR . $this->newFileName;
        $this->checkSum = md5_file($file['tmp_name']);

        foreach (glob($this->uploadDir . DIRECTORY_SEPARATOR . '*.csv') as $filename) {
            if ($this->checkSum === md5_file($filename)) {
                throw new \Exception('File already exists');
            }
        }
        if (!move_uploaded_file($file['tmp_name'], $this->uploadPath)) {
            throw new \Exception('Import failed');
        }
    }

    public function logUploaded($fileRegisterer): void
    {
       $fileRegisterer->register($this->newFileName, $this->checkSum, $this->uploadPath);
    }

    public function getUploadPath(): string
    {
        return $this->uploadPath;
    }
}
