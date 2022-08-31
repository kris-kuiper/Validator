<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Exceptions;

use Exception;

class ValidatorException extends Exception
{
    /**
     * Constructor
     */
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    /**
     * Thrown when a provided parameters name does not exist in the parameter bag
     */
    public static function parameterNotFound(string $parameterName): self
    {
        return new self(sprintf('Parameter "%s" does not exists.', $parameterName));
    }

    /**
     * Thrown when a format for using combine objects does not exist
     */
    public static function formatTypeNotFound(string $type, string $format): self
    {
        return new self(sprintf('Format type "%s" not found in format "%s".', $type, $format));
    }

    /**
     * Thrown when a custom rule could not be found in the collection
     */
    public static function customRuleNotFound(string $ruleName): self
    {
        return new self(sprintf('Custom rule "%s" not found.', $ruleName));
    }

    /**
     * Thrown when using a date format which is not a valid date
     */
    public static function incorrectDateFormatUsed(string $date): self
    {
        return new self(sprintf('Date "%s" is not a correct date format', $date));
    }
}
