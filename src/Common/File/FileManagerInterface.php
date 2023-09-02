<?php

namespace App\Common\File;

interface FileManagerInterface
{
    public function getContent(string $fileName): string;
}
