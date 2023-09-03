<?php

namespace App\Common\File;

use Traversable;

interface FileManagerInterface
{
    public function getRowsFromFile(string $fileName): Traversable|string;
}
