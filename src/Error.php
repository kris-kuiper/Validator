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
    public function getPath(): Path
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
    public function getMessage(): ?string
    {
        return $this->rule->getParsedMessage();
    }

    /**
     * Returns the raw (without variable parameters) error message
     */
    public function getRawMessage(): ?string
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
        return substr(md5($this->getRawMessage()), 0, 10);
    }

    /**
     * Returns if a provided field identifier matches the current field by name
     */
    public function match(string $identifier): bool
    {
        return preg_match($this->identifierToRegex($identifier), $this->field?->getFieldName()) || preg_match($this->identifierToRegex($identifier), $this->getPath()->getIdentifier());
    }

    /**
     * Converts a provided field identifier to a regex string
     */
    private function identifierToRegex(string $identifier): string
    {
        return '/^' . str_replace('\*', '[^\.]+', preg_quote($identifier, '/')) . '$/';
    }
}
