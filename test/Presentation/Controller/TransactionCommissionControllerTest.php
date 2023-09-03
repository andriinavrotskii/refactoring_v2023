<?php

use App\Common\File\FileManagerInterface;
use App\Common\Output\OutputInterface;
use App\Presentation\Controller\TransactionCommissionController;
use App\Presentation\ValueObject\Input;
use App\TransactionCommission\TransactionCommissionService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class TransactionCommissionControllerTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testCalculateCommission(
        array $fileManagerData,
        array $transactionCommissionServiceData,
        array $outputData,
        array $loggerData,
    ): void {
        $inputMock = $this->createMock(Input::class);
        $inputMock->expects($this->once())
            ->method('getInputFileName')
            ->willReturn('filename');

        $fileManagerMock = $this->createMock(FileManagerInterface::class);
        $fileManagerMock->expects($this->exactly($fileManagerData['expects']))
            ->method('getRowsFromFile')
            ->willReturn($fileManagerData['willReturn']);

        $transactionCommissionServiceMock = $this->createMock(TransactionCommissionService::class);
        $transactionCommissionServiceMock->expects($this->exactly($transactionCommissionServiceData['expects']))
            ->method('calculateCommission');

        $outputMock = $this->createMock(OutputInterface::class);
        $outputMock->expects($this->exactly($outputData['expects']))
            ->method('echo');

        $loggerMock = $this->createMock(LoggerInterface::class);
        $loggerMock->expects($this->exactly($loggerData['expects']))
            ->method('alert');

        $controller = new TransactionCommissionController(
            $transactionCommissionServiceMock,
            $fileManagerMock,
            $outputMock,
            $loggerMock,
        );

        $controller->run($inputMock);
    }

    public static function dataProvider(): iterable
    {
        yield [
            'fileManager' => [
                'expects' => 1,
                'willReturn' => new ArrayObject(['{"bin":"11111111","amount":"111.00","currency":"EUR"}']),
            ],
            'transactionCommissionService' => [
                'expects' => 1,
            ],
            'output' => [
                'expects' => 1,
            ],
            'logger' => [
                'expects' => 0,
            ],
        ];
    }
}