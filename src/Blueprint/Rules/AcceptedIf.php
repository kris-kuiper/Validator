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

    private array $accepted = ['yes', 'on', '1', 'true', 1, true];

    /**
     * Constructor
     */
    public function __construct(private string $fieldName, private mixed $value, array $accepted = [])
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
        $accepted = $this->getValue();
        $targetValue = $this->getValidationData()->path($this->fieldName)->getValue();

        if ($this->value === $targetValue) {
            return true === in_array($accepted, $this->accepted, true);
        }

        return true;
    }
}
