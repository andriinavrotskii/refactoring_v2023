<?php

use App\Common\File\FileManagerInterface;
use App\Common\Output\OutputInterface;
use App\Common\ValueObject\TransactionData;
use App\Presentation\Controller\TransactionCommissionController;
use App\Presentation\Factory\TransactionDataFactory;
use App\Presentation\ValueObject\Input;
use App\TransactionCommission\TransactionCommissionService;
use App\TransactionCommission\ValueObject\Commission;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class TransactionCommissionControllerTest extends TestCase
{
    public function testPositive(): void {
        $inputMock = $this->createMock(Input::class);
        $inputMock
            ->expects($this->once())
            ->method('getInputFileName')
            ->willReturn('filename');

        $fileManagerMock = $this->createMock(FileManagerInterface::class);
        $fileManagerMock
            ->expects($this->exactly(1))
            ->method('getRowsFromFile')
            ->willReturn(new ArrayIterator(['string']));

        $transactionDataMock = $this->createMock(TransactionData::class);

        $transactionDataFactoryMock = $this->createMock(TransactionDataFactory::class);
        $transactionDataFactoryMock
            ->expects($this->exactly(1))
            ->method('createFromString')
            ->with('string')
            ->willReturn($transactionDataMock);

        $commissionMock = $this->createMock(Commission::class);
        $transactionCommissionServiceMock = $this->createMock(TransactionCommissionService::class);
        $transactionCommissionServiceMock
            ->expects($this->exactly(1))
            ->method('calculateCommission')
            ->with($transactionDataMock)
            ->willReturn($commissionMock);

        $outputMock = $this->createMock(OutputInterface::class);
        $outputMock
            ->expects($this->exactly(1))
            ->method('echo');

        $loggerMock = $this->createMock(LoggerInterface::class);
        $loggerMock
            ->expects($this->exactly(0))
            ->method('alert');

        $controller = new TransactionCommissionController(
            $transactionCommissionServiceMock,
            $fileManagerMock,
            $transactionDataFactoryMock,
            $outputMock,
            $loggerMock,
        );

        $controller->run($inputMock);
    }
}
