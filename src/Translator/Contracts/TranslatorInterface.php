<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Translator\Contracts;

interface TranslatorInterface
{
    /**
     * Sets new data that will be used for retrieving and modifying items
     */
    public function setData(array &$data): void;

    /**
     * Stores a new piece of data and tries to merge the data if already exists
     */
    public function add(string|int|float $key, mixed $value);

    /**
     * Stores a new piece of data and overwrites the data if already exists
     */
    public function set(string|int|float|array $key, mixed $value): void;

    /**
     * Returns if an item exists
     */
    public function has(string|int|float $key): bool;

    /**
     * Removes data based on key
     */
    public function remove(string|int|float $key): void;

    /**
     * Retrieves data based on key
     */
    public function get(string|int|float $key): array;
}
