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
    public function add(string|int $key, mixed $value): void;

    /**
     * Stores a new piece of data and overwrites the data if already exists
     */
    public function set(string|int|array $key, mixed $value): void;

    /**
     * Returns if an item exists
     */
    public function has(string|int $key): bool;

    /**
     * Removes data based on key
     */
    public function remove(string|int $key): void;

    /**
     * Retrieves data based on key
     */
    public function get(string|int $key): array;
}
