<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class AcceptedIf extends AbstractRule
{
    public const NAME = 'acceptedIf';

    /**
     * @inheritdoc
     */
    protected string $message = 'Should be accepted';

    /**
     * Constructor
     */
    public function __construct(string $fieldName, mixed $value, array $accepted = [])
    {
        parent::__construct();

        if (0 === count($accepted)) {
            $accepted = ['yes', 'on', '1', 'true', 1, true];
        }

        $this->setParameter('fieldName', $fieldName);
        $this->setParameter('value', $value);
        $this->setParameter('accepted', $accepted);
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
        $accepted = $this->getValue();
        $targetValue = $this->getValidationData()->path($this->getParameter('fieldName'))->getValue();

        if ($this->getParameter('value') === $targetValue) {
            return true === in_array($accepted, $this->getParameter('accepted'), true);
        }

        return true;
    }
}
