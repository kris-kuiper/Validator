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
    protected string $message = 'Should be accepted';

    /**
     * Constructor
     */
    public function __construct(string $fieldName, array $accepted = [])
    {
        parent::__construct();
        if (0 === count($accepted)) {
            $accepted = ['yes', 'on', '1', 'true', 1, true];
        }

        $this->setParameter('accepted', $accepted);
        $this->setParameter('fieldName', $fieldName);
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
        $fieldName = $this->getParameter('fieldName');

        if (false === $empty) {
            return true === $this->isAccepted($value);
        }

        $paths = $this->getPaths($fieldName);

        foreach ($paths as $path) {
            if (false === $this->isEmpty($path->getValue())) {
                return true === $this->isAccepted($value);
            }
        }

        return true === $this->isAccepted($value);
    }

    /**
     * @throws ValidatorException
     */
    private function isAccepted(mixed $value): bool
    {
        $accepted = $this->getParameter('accepted');
        return true === in_array($value, $accepted, true);
    }
}
