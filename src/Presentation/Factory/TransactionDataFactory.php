<?php

namespace App\Presentation\Factory;

use App\Common\Exception\ValidationException;
use App\Common\ValueObject\Amount;
use App\Common\ValueObject\Bin;
use App\Common\ValueObject\Currency;
use App\Common\ValueObject\TransactionData;

class TransactionDataFactory
{
    /**
     * @throws ValidationException
     */
    public function createFromString(string $inputData): TransactionData
    {
        $data = json_decode($inputData, true, 2);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ValidationException(sprintf('Not valid json string: \'%s\'.', $inputData));
        }

        $errors = [];

        try {
            $bin = Bin::createFromString($data['bin'] ?? '');
        } catch (ValidationException $exception) {
            $errors[] = $exception->getMessage();
        }

        try {
            $amount = Amount::createFromString($data['amount'] ?? '');
        } catch (ValidationException $exception) {
            $errors[] = $exception->getMessage();
        }

        try {
            $currency = Currency::createFromString($data['currency'] ?? '');
        } catch (ValidationException $exception) {
            $errors[] = $exception->getMessage();
        }

        if (false === empty($errors)) {
            throw new ValidationException(sprintf(
                'Not valid json string: \'%s\'. Errors: \'%s\'.',
                $inputData,
                implode(' ', $errors),
            ));
        }

        return new TransactionData($bin, $amount, $currency);
    }
}
