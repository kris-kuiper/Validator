<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Combine;

class Combine
{
    /**
     * Contains the glue that will hold all the values together
     */
    private ?string $glue = null;

    /**
     * Contains a format that will be used like sprintf
     */
    private ?string $format = null;

    /**
     * Contains the name of the combine
     */
    private ?string $alias = null;

    /**
     * Contains all the field names of the combine
     */
    private array $fieldNames;

    /**
     * Constructor
     */
    public function __construct(string ...$fieldNames)
    {
        $this->fieldNames = $fieldNames;
    }

    /**
     * Joins field names with the glue string between each field name
     */
    public function glue(string $glue): self
    {
        $this->glue = $glue;
        return $this;
    }

    /**
     * Converts the field name values to the specific given format
     */
    public function format(string $format): self
    {
        $this->format = $format;
        return $this;
    }

    /**
     * Gives the combined field names a new single name that can be used for validation
     */
    public function alias(string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * Returns the field name
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * Returns the glue
     */
    public function getGlue(): ?string
    {
        return $this->glue;
    }

    /**
     * Returns the format
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * Returns the fields with their values
     */
    public function getFieldNames(): array
    {
        return $this->fieldNames;
    }
}
