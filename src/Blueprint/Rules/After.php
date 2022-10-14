<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use DateTime;
use KrisKuiper\Validator\Blueprint\Traits\DateTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class After extends AbstractRule
{
    use DateTrait;

    public const NAME = 'after';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Date should be after :date';

    private DateTime $date;

    /**
     * Constructor
     * @throws ValidatorException
     */
    public function __construct(string $date, private string $format = 'Y-m-d')
    {
        $this->date = $this->createDate($date, $format);

        parent::__construct();

        $this->setParameter('date', $date);
        $this->setParameter('format', $this->format);
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

        if (false === is_string($value) && false === is_numeric($value)) {
            return false;
        }

        try {
            $date = $this->createDate((string) $value, $this->format);
        } catch (ValidatorException) {
            return false;
        }

        $timestamp = $date->getTimestamp();
        return $timestamp > $this->date->getTimestamp();
    }
}
