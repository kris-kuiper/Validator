<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Traits\EmptyTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Prohibits extends AbstractRule
{
    use EmptyTrait;

    public const NAME = 'prohibits';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Invalid input';

    /**
     * Constructor
     */
    public function __construct(string ...$fieldNames)
    {
        parent::__construct();
        $this->setParameter('fieldNames', $fieldNames);
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
        $fieldName = $this->getField()?->getFieldName();
        $fieldNames = $this->getParameter('fieldNames');
        $validationData = $this->getValidationData()->toArray();

        if (false === array_key_exists($fieldName ?? '', $validationData)) {
            return true;
        }

        foreach ($fieldNames as $fieldName) {
            if (true === array_key_exists($fieldName ?? '', $validationData)) {
                return false;
            }
        }

        return true;
    }
}
