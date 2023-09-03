<?php

namespace App\Presentation\ValueObject;

use App\Common\Exception\InputException;

class Input
{
    public function __construct(
        private readonly array $argv,
    ) {
    }

    public static function createFromArgv(array $argv): self
    {
        return new Input($argv);
    }

    public function getInputFileName(): string
    {
        $inputFileName = $this->argv[1] ?? null;

        if (null === $inputFileName) {
            throw new InputException('Please provide file with input data.');
        }

        return $inputFileName;
    }
}
