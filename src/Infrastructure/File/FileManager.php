<?php

namespace App\Infrastructure\File;

class FileManager
{
    private const NO_CONTENT = '';

    public function getContent(string $fileName): string
    {
        $contents = file_get_contents($fileName);

        if (false === $contents) {
            return self::NO_CONTENT;
        }

        return $contents;
    }
}