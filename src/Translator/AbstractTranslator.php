<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Translator;

use KrisKuiper\Validator\Translator\Contracts\TranslatorInterface;

abstract class AbstractTranslator implements TranslatorInterface
{
    /**
     * Contains the data for retrieving and modifying items
     */
    protected array $data = [];

    /**
     * Constructor
     */
    public function __construct(array &$data = [])
    {
        $this->data = &$data;
    }

    /**
     * Sets new data that will be used for retrieving and modifying items
     */
    public function setData(array &$data): void
    {
        $this->data = &$data;
    }

    /**
     * Returns the original data
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
