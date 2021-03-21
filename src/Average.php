<?php declare(strict_types=1);

class Average
{
    function ensureIsValidArrayOfIntegers(array $numbers): void
    {
        foreach ($numbers as $number) {
            if (!filter_var($number, FILTER_VALIDATE_INT)) {
                throw new InvalidArgumentException(
                    sprintf(
                        '"%s" is not a valid number',
                        $number
                    )
                );
            }
        }
    }

    public function getAverage(array $numbers): float
    {
        $this->ensureIsValidArrayOfIntegers($numbers);

        return array_sum($numbers) / count($numbers);
    }

    public function logAverage(array $numbers, Logger $logger): void
    {
        $this->ensureIsValidArrayOfIntegers($numbers);

        $logger->log(array_sum($numbers) / count($numbers));
    }
}
