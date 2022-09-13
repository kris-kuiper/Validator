<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Traits\EmptyTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class AcceptedNotEmpty extends AbstractRule
{
    use EmptyTrait;

    public const NAME = 'acceptedNotEmpty';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Should be accepted';

    private array $accepted = ['yes', 'on', '1', 'true', 1, true];

    /**
     * Constructor
     */
    public function __construct(private string $fieldName, array $accepted = [])
    {
        parent::__construct();

        if (0 !== count($accepted)) {
            $this->accepted = $accepted;
        }

        $this->setParameter('fieldName', $this->fieldName);
        $this->setParameter('accepted', $this->accepted);
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
        $empty = $this->isEmpty($value);

        if (false === $empty) {
            return true === $this->isAccepted($value);
        }

        $paths = $this->getPaths($this->fieldName);

        foreach ($paths as $path) {
            if (false === $this->isEmpty($path?->getValue())) {
                return true === $this->isAccepted($value);
            }
        }

        return true === $this->isAccepted($value);
    }

    private function isAccepted(mixed $value): bool
    {
        return true === in_array($value, $this->accepted, true);
    }
}
