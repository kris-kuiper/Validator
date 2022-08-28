<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Translator;

class Path
{
    private string $identifier;

    /**
     * Constructor
     */
    public function __construct(private array $path, private mixed $value = null)
    {
        $this->identifier = implode('.', $path);
    }

    /**
     * Returns the value
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Returns the path as an array
     */
    public function getPath(): array
    {
        return $this->path;
    }

    /**
     * Returns the identifier
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Returns if a provided field identifier matches the current field by name
     */
    public function match(string $identifier): bool
    {
        return (bool) preg_match($this->identifierToRegex($identifier), $this->getIdentifier());
    }

    /**
     * Converts a provided field identifier to a regex string
     */
    private function identifierToRegex(string $identifier): string
    {
        return '/^' . str_replace('\*', '[^\.]+', preg_quote($identifier, '/')) . '$/';
    }
}
