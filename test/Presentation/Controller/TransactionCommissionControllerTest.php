<?php

use App\Common\File\FileManagerInterface;
use App\Common\Output\OutputInterface;
use App\Presentation\Controller\TransactionCommissionController;
use App\Presentation\ValueObject\Input;
use App\TransactionCommission\TransactionCommissionService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class TransactionCommissionControllerTest extends TestCase
{
    public function testFirst(): void
    {
        $this->assertTrue(true);

        $inputMock = $this->createMock(Input::class);
        $inputMock->expects($this->once())
            ->method('getInputFileName')
            ->willReturn('filename');


        $transactionCommissionServiceMock = $this->createMock(TransactionCommissionService::class);
        $fileManagerMock = $this->createMock(FileManagerInterface::class);
        $outputMock = $this->createMock(OutputInterface::class);
        $loggerMock = $this->createMock(LoggerInterface::class);

        $controller = new TransactionCommissionController(
            $transactionCommissionServiceMock,
            $fileManagerMock,
            $outputMock,
            $loggerMock,
        );

        $controller->run($inputMock);
    }
}