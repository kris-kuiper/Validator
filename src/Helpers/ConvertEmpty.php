<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Helpers;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class ConvertEmpty
{
    // Converting mode for string, arrays and null values
    public const CONVERT_EMPTY = 0;

    // Converting mode for empty strings e.q. ""
    public const CONVERT_EMPTY_STRING = 1;

    // Converting mode for empty arrays e.q []
    public const CONVERT_EMPTY_ARRAY = 2;

    // Converting mode for NULL values
    public const CONVERT_NULL = 4;

    // Contains all the converting modes
    public const CONVERT_MODES = [
        self::CONVERT_EMPTY,
        self::CONVERT_EMPTY_STRING,
        self::CONVERT_EMPTY_ARRAY,
        self::CONVERT_NULL,
    ];

    /**
     * Constructor
     * @throws ValidatorException
     */
    public function __construct(private mixed $convertTo = null, private int $mode = self::CONVERT_EMPTY, private bool $recursive = true)
    {
        if (false === in_array($mode, self::CONVERT_MODES, true)) {
            throw ValidatorException::incorrectConvertMode($mode);
        }

        if (self::CONVERT_EMPTY === $this->mode) {
            $this->mode = array_sum(self::CONVERT_MODES) - self::CONVERT_EMPTY;
        }
    }

    /**
     * Converts empty string, array's and null values to a provided value
     */
    public function convert(array $data): array
    {
        foreach ($data as $key => $value) {
            //Check if converting should be executed recursively if value is an array
            if (true === is_array($value) && true === $this->recursive) {
                foreach ($value as $k => $v) {
                    $data[$key][$k] = $this->convert($v);
                }
            }

            if (self::CONVERT_EMPTY_STRING & $this->mode && '' === $value) { //Check for empty string
                $data[$key] = $this->convertTo;
            } elseif (self::CONVERT_NULL & $this->mode && null === $value) { //Check if value is null
                $data[$key] = $this->convertTo;
            } elseif (self::CONVERT_EMPTY_ARRAY & $this->mode && true === is_countable($value) && 0 === count($value)) { //Check if empty countable i.e. array
                $data[$key] = $this->convertTo;
            }
        }

        return $data;
    }
}
