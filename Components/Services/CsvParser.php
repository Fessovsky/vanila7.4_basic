<?php

namespace Components\Services;

use Generator;
use IteratorAggregate;
use RuntimeException;

final class CsvParser implements IteratorAggregate
{
    private string $filePath = '';
    private string $delimiter;
    private string $enclosure;
    private string $escape;

    public function __construct(
        string $delimiter = ',',
        string $enclosure = '"',
        string $escape = '\\'
    ) {
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escape = $escape;
    }

    public function getIterator(): Generator
    {
        if(empty($this->filePath)) {
            throw new RuntimeException('File path is empty');
        }
        $handle = fopen($this->filePath, 'r');
        if (!$handle) {
            throw new RuntimeException('Cannot open file');
        }

        try {
            while (($row = fgetcsv($handle, 1000, $this->delimiter, $this->enclosure, $this->escape)) !== false) {
                $sanitizedRow = $this->sanitizeRow($row);
                if ($this->validateRow($sanitizedRow)) {
                    yield $sanitizedRow;
                } else {
                    // TODO: Log invalid row
                    continue;
                }
            }
        } finally {
            fclose($handle);
        }
    }

    private function sanitizeRow(array $row): array
    {
        if (empty($row[count($row) - 1])) {
            array_pop($row);
        }
        return array_map('trim', $row);
    }

    private function validateRow(array $row): bool
    {
        if (count($row) < 2) {
            return false;
        }

        if (!preg_match('/^\d+$/', $row[0])) {
            return false;
        }

        if (!preg_match('/^[\p{L}\s\.\'-]+$/u', $row[1])) {
            return false;
        }

        return true;
    }

    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }
}
