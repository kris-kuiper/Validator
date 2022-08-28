<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use JsonException;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsJSON extends AbstractRule
{
    public const NAME = 'isJSON';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value should be a valid JSON string';

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

        if(false === is_string($value)) {
            return false;
        }

        try {
            json_decode($value, false, 512, JSON_THROW_ON_ERROR);
        }
        catch (JsonException) {
            return false;
        }

        return true === (json_last_error() === JSON_ERROR_NONE);
    }
}
