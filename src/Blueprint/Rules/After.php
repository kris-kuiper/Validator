<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use DateTime;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class After extends AbstractRule
{
    public const NAME = 'after';

    /**
     * @inheritdoc
     */
    protected string $message = 'Date should be after :date';

    /**
     * Constructor
     * @throws ValidatorException
     */
    public function __construct(string $date, string $format = 'Y-m-d')
    {
        if (false === DateTime::createFromFormat($format, $date)) {
            throw ValidatorException::incorrectDateFormatUsed($date);
        }

        parent::__construct();
        $this->setParameter('date', $date);
        $this->setParameter('format', $format);
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function isValid(): bool
    {
        $value = $this->getValue();
        if (true === is_string($value) || true === is_numeric($value)) {
            $format = $this->getParameter('format');
            $timestamp = DateTime::createFromFormat($format, $this->getParameter('date'))->getTimestamp();
            $date = DateTime::createFromFormat($format, (string)$value);
            if (false === $date) {
                return false;
            }

            return $date->getTimestamp() > $timestamp;
        }

        return false;
    }
}
