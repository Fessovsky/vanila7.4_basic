<?php

namespace Components\Controllers;

use Components\Contracts\ControllerInterface;
use Components\Contracts\FileRegistererInterface;
use Components\Contracts\FileUploaderInterface;
use Components\Contracts\PageInterface;
use Components\Contracts\RenderInterface;
use Components\DB;
use Components\Pages\Upload;
use Components\Repositories\FilesRepository;
use Components\Repositories\UsersRepository;
use Components\Services\CsvFileUploader;
use Components\Services\CsvParser;
use Components\Utils\RenderHTML;
use IteratorAggregate;

class UploadController implements ControllerInterface
{
    private FileUploaderInterface $uploader;
    private IteratorAggregate $parser;
    private RenderInterface $renderer;
    private PageInterface $page;
    private FileRegistererInterface $fileRegisterer;

    public function __construct() {
        $this->renderer = new RenderHTML();
        $this->page = new Upload();
        $this->db = DB::getInstance()->getConnection();

        $uploadDir = getenv('UPLOAD_DIR');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $this->uploader = new CsvFileUploader($uploadDir);
        $this->parser = new CsvParser();
        $this->fileRegisterer = new FilesRepository($this->db);
        $this->usersRepository = new UsersRepository($this->db);
    }

    public function upload(): void
    {
        $this->uploader->upload($_FILES);
        $this->uploader->logUploaded($this->fileRegisterer);
        $this->parser->setFilePath($this->uploader->getUploadPath());
        $generator = $this->parser->getIterator();
        $this->usersRepository->saveBatch($generator);
        unlink($this->uploader->getUploadPath());
        $this->fileRegisterer->unregister($this->uploader->getUploadPath());
    }

    public function index(): void
    {
        $this->renderer->render($this->page->getHtml());
    }
}