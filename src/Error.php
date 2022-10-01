<?php

declare(strict_types=1);

namespace KrisKuiper\Validator;

use KrisKuiper\Validator\Blueprint\Rules\AbstractRule;
use KrisKuiper\Validator\Fields\Field;
use KrisKuiper\Validator\Translator\Path;

class Error
{
    private ?Field $field;

    /**
     * Constructor
     */
    public function __construct(private AbstractRule $rule)
    {
        $this->field = $this->rule->getField();
    }

    /**
     * Returns the value that has been validated
     * @throws Exceptions\ValidatorException
     */
    public function getValue(): mixed
    {
        return $this->field?->getValue();
    }

    /**
     * Returns the path to the value in the validation data
     */
    public function getPath(): ?Path
    {
        return $this->field?->getPath();
    }

    /**
     * Returns the name of the used rule
     */
    public function getRuleName(): ?string
    {
        return $this->rule->getName();
    }

    /**
     * Returns the name of the field
     */
    public function getFieldName(): float|int|string|null
    {
        return $this->field?->getFieldName();
    }

    /**
     * Returns the parsed (with variable parameters) error message
     */
    public function getMessage(): float|int|string
    {
        return $this->rule->getParsedMessage();
    }

    /**
     * Returns the raw (without variable parameters) error message
     */
    public function getRawMessage(): int|float|string
    {
        return $this->rule->getRawMessage();
    }

    /**
     * Returns the parameters used for validation
     */
    public function getParameters(): ?array
    {
        return $this->rule->getParameters();
    }

    /**
     * Returns a unique identifier for the error based on the raw error message
     */
    public function getId(): string
    {
        $message = (string) $this->getRawMessage();
        return substr(md5($message), 0, 10);
    }

    /**
     * Returns if a provided field identifier matches the current field by name
     */
    public function match(string $identifier): bool
    {
        $fieldName = $this->field?->getFieldName();

        if ((null !== $fieldName) && true === (bool) preg_match($this->identifierToRegex($identifier), (string) $fieldName)) {
            return true;
        }

        $pathIdentifier = $this->getPath()?->getIdentifier();
        return (bool) preg_match($this->identifierToRegex($identifier), $pathIdentifier ?? '');
    }

    /**
     * Converts a provided field identifier to a regex string
     */
    private function identifierToRegex(string $identifier): string
    {
        return '/^' . str_replace('\*', '[^\.]+', preg_quote($identifier, '/')) . '$/';
    }
}
