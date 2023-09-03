<?php

namespace App\Infrastructure\File;

use App\Common\File\FileManagerInterface;
use Traversable;

class FileManager implements FileManagerInterface
{
    public function getRowsFromFile(string $fileName): Traversable|string
    {
        $file = fopen($fileName, 'r');

        if (!$file) {
            yield;
        }

        while (($row = fgets($file)) !== false) {
            $row = trim($row);

            if (empty($row)) {
                continue;
            }

            yield $row;
        }

        fclose($file);
    }
}