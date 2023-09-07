<?php

namespace App\Presentation\Controller;

use App\Common\Exception\InputException;
use App\Common\File\FileManagerInterface;
use App\Common\Output\OutputInterface;
use App\Presentation\Factory\TransactionDataFactory;
use App\Presentation\ValueObject\Input;
use App\TransactionCommission\TransactionCommissionService;
use Exception;
use Psr\Log\LoggerInterface;

class TransactionCommissionController
{
    public function __construct(
        private readonly TransactionCommissionService $transactionCommissionService,
        private readonly FileManagerInterface $fileManager,
        private readonly TransactionDataFactory $transactionDataFactory,
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
                    $this->transactionDataFactory->createFromString($row)
                );

                $this->output->echo($commission);
            } catch (Exception $exception) {
                $this->logger->alert($exception->getMessage());
                continue;
            }
        }
    }
}
