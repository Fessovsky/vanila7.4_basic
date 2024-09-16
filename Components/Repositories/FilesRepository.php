<?php

namespace Components\Repositories;

use Components\Contracts\FileRegistererInterface;

final class FilesRepository implements FileRegistererInterface
{
    public function __construct($db)
    {
        $this->dbPDO = $db;
    }

    public function register($fileName, $checkSum, $filePath): void
    {
        try {
            $this->dbPDO->beginTransaction();
            $stmt = $this->dbPDO->prepare("INSERT INTO files (name, checksum, path) VALUES (:name, :checksum, :path)");
            $stmt->execute(['name' => $fileName, 'checksum' => $checkSum, 'path' => $filePath]);
            $this->dbPDO->commit();
        } catch (\Exception $e) {
            $this->dbPDO->rollBack();
            throw new \Exception('Error registering file in database');
        }
    }

    public function unregister($filePath)
    {
        try {
            $this->dbPDO->beginTransaction();
            $stmt = $this->dbPDO->prepare("DELETE FROM files WHERE path = :path");
            $stmt->execute(['path' => $filePath]);
            $this->dbPDO->commit();
        } catch (\Exception $e) {
            $this->dbPDO->rollBack();
            throw new \Exception('Error unregistering file in database');
        }
    }
}