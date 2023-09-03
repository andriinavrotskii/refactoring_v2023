<?php

namespace App\Presentation\Controller;

use App\Common\Exception\InputException;
use App\Common\File\FileManagerInterface;
use App\Common\Output\OutputInterface;
use App\Common\ValueObject\TransactionData;
use App\Presentation\ValueObject\Input;
use App\TransactionCommission\TransactionCommissionService;
use Psr\Log\LoggerInterface;
use Throwable;

class TransactionCommissionController
{
    public function __construct(
        private readonly TransactionCommissionService $transactionCommissionService,
        private readonly FileManagerInterface $fileManager,
        private readonly OutputInterface $output,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * @throws InputException
     */
    public function run(Input $input): void
    {
        $inputFileName = $input->getInputFileName();

        foreach ($this->fileManager->getRowsFromFile($inputFileName) as $row) {
            try {
                $commission = $this->transactionCommissionService->calculateCommission(
                    TransactionData::createFromString($row)
                );

                $this->output->echo($commission);
            } catch (Throwable $exception) {
                $this->logger->alert($exception->getMessage());
                continue;
            }
        }
    }
}
