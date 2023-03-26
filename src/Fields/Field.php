<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Fields;

use KrisKuiper\Validator\Blueprint\Collections\FieldOptionCollection;
use KrisKuiper\Validator\Collections\CombineProxyCollection;
use KrisKuiper\Validator\Collections\MiddlewareProxyCollection;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Translator\Path;

class Field
{
    private Path $path;
    private bool $bailed = false;
    private bool $shouldBail = false;
    private string|int $fieldName;
    private FieldOptionCollection $fieldOptionCollection;
    private CombineProxyCollection $combineProxyCollection;
    private MiddlewareProxyCollection $middlewareProxyCollection;

    /**
     * Constructor
     */
    public function __construct(Path $path, int|string $fieldName, CombineProxyCollection $combineProxyCollection)
    {
        $this->path = $path;
        $this->fieldName = $fieldName;
        $this->fieldOptionCollection = new FieldOptionCollection();
        $this->middlewareProxyCollection = new MiddlewareProxyCollection();
        $this->combineProxyCollection = $combineProxyCollection;
    }

    /**
     * Returns the path object of the field
     */
    public function getPath(): Path
    {
        return $this->path;
    }

    /**
     * Sets a new path object for the field
     */
    public function setPath(Path $path): void
    {
        $this->path = $path;
    }

    /**
     * Returns the name of the field
     */
    public function getFieldName(): int|string
    {
        return $this->fieldName;
    }

    /**
     * Returns a field option collection which contains all the rules and bailing options
     */
    public function getFieldOptions(): FieldOptionCollection
    {
        return $this->fieldOptionCollection;
    }

    /**
     * Returns all the middleware as a collection
     */
    public function getMiddleware(): MiddlewareProxyCollection
    {
        return $this->middlewareProxyCollection;
    }

    /**
     * Returns the value of the field
     * This will retrieve the value from the path or from a combine object
     * @throws ValidatorException
     */
    public function getValue(): mixed
    {
        $fieldName = $this->getFieldName();

        //Check if the field name is a known combine instance
        if ($combine = $this->combineProxyCollection->getByAlias($fieldName)) {
            return $combine->getValue();
        }

        return $this->getPath()->getValue();
    }

    /**
     * Returns if the field should bail (stop) further rules
     */
    public function isBailed(): bool
    {
        return $this->bailed;
    }

    /**
     * Sets the bailed option to prevent further validation for this field
     */
    public function setBailed(bool $bailed): void
    {
        $this->bailed = $bailed;
    }

    public function setShouldBail(bool $bail): void
    {
        $this->shouldBail = $bail;
    }

    public function getShouldBail(): bool
    {
        return $this->shouldBail;
    }

    /**
     * Returns if a provided field identifier matches the current field by name
     */
    public function match(string $identifier): bool
    {
        return (bool) preg_match($this->identifierToRegex($identifier), (string) $this->getFieldName());
    }

    /**
     * Converts a provided field identifier to a regex string
     */
    private function identifierToRegex(string $identifier): string
    {
        return '/^' . str_replace('\*', '[^\.]+', preg_quote($identifier, '/')) . '$/';
    }
}
