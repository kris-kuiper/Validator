<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use DateTime;
use KrisKuiper\Validator\Blueprint\Traits\DateTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class DateBetween extends AbstractRule
{
    use DateTrait;

    public const NAME = 'dateBetween';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Date should be between :from and :to';

    private DateTime $from;
    private DateTime $to;

    /**
     * Constructor
     * @throws ValidatorException
     */
    public function __construct(string $from, string $to, private string $format = 'Y-m-d')
    {
        parent::__construct();

        $this->setParameter('from', $from);
        $this->setParameter('to', $to);
        $this->setParameter('format', $this->format);

        $this->from = $this->createDate($from, $this->format);
        $this->to = $this->createDate($to, $this->format);
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
            try {
                $date = $this->createDate((string) $value, $this->format);
            } catch (ValidatorException) {
                return false;
            }

            $timestamp = $date->getTimestamp();
            return $timestamp > $this->from->getTimestamp() && $timestamp < $this->to->getTimestamp();
        }

        return false;
    }
}
