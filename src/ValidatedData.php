<?php

declare(strict_types=1);

namespace KrisKuiper\Validator;

use JsonException;
use KrisKuiper\Validator\Translator\Path;
use KrisKuiper\Validator\Translator\PathTranslator;
use stdClass;

class ValidatedData
{
    private array $data = [];
    private array $not = [];
    private array $only = [];
    private ?string $pluck = null;

    /**
     * Excludes (blacklist) all given field names in the result set
     */
    public function not(...$fieldNames): self
    {
        return $this->createInstance($fieldNames, $this->only, $this->pluck);
    }

    /**
     * Includes (whitelist) all given field names in the result set
     */
    public function only(...$fieldNames): self
    {
        return $this->createInstance($this->not, $fieldNames, $this->pluck);
    }

    /**
     * Retrieves all the fields which matches the provided field name
     */
    public function pluck(string $fieldName): self
    {
        return $this->createInstance($this->not, $this->only, $fieldName);
    }

    /**
     * Returns an stdClass with the validated data
     * @throws JsonException
     */
    public function toObject(): stdClass
    {
        return json_decode($this->toJson(), false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Returns an JSON string with the validated data
     * @throws JsonException
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT | JSON_INVALID_UTF8_IGNORE);
    }

    /**
     * Returns an array with the validated data
     */
    public function toArray(): array
    {
        $output = $this->data;

        $output = $this->filterNotItems($output);
        $output = $this->filterOnlyItems($output);
        return $this->pluckItems($output);
    }

    /**
     * Adds a new value to the validated values
     */
    public function add(Path $item): void
    {
        $path = $item->getPath();
        $value = $item->getValue();
        $index = array_pop($path);
        $array = [];

        if (count($path) > 0) {
            $this->insertIntoArray($array, $path, [$index => $value]);
        } elseif (null === $index) {
            $array = [$value];
        } else {
            $array = [$index => $value];
        }

        $this->data = array_replace_recursive($this->data, $array);
    }

    /**
     * Applies the pluck if there is one
     */
    private function pluckItems(array $output): array
    {
        if (null === $this->pluck) {
            return $output;
        }

        $pluck = $output;
        return (new PathTranslator($pluck))->get($this->pluck);
    }

    /**
     * Excludes values in result set based on blacklist
     */
    private function filterNotItems(array $output): array
    {
        foreach ($this->not as $exclude) {
            $translator = new PathTranslator($output);
            $paths = $translator->path($exclude);

            if (0 === $paths->count()) {
                continue;
            }

            foreach ($paths as $keys) {
                $this->removeFromArray($output, $keys->getPath());
            }
        }

        return $output;
    }

    /**
     * Includes values in result set based on whitelist
     */
    private function filterOnlyItems(array $output): array
    {
        if (0 === count($this->only)) {
            return $output;
        }

        $only = [];

        foreach ($this->only as $include) {
            $translator = new PathTranslator($output);
            $paths = $translator->path($include);

            if (0 === $paths->count()) {
                continue;
            }

            foreach ($paths as $keys) {
                $this->insertIntoArray($only, $keys->getPath(), $keys->getValue());
            }
        }

        return $only;
    }

    /**
     * Inserts element into a multidimensional array by giving an array path which represents the path (depth) to the value
     */
    private function insertIntoArray(&$array, array $path, $value): void
    {
        $last = array_pop($path);

        foreach ($path as $key) {
            if (false === array_key_exists($key, $array) || (true === array_key_exists($key, $array) && false === is_array($array[$key]))) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        if (true === isset($array[$last])) {
            $data = $array[$last];

            if (false === is_array($data)) {
                $array[$last] = [$data];
            }

            $array[$last][] = $value;
        } else {
            $array[$last] = $value;
        }
    }

    /**
     * Removes element from a multidimensional array by giving an array path which represents the path (depth) to the value
     */
    private function removeFromArray(&$array, array $path): void
    {
        $previous = null;
        $tmp = &$array;

        foreach ($path as $node) {
            $previous = &$tmp;
            $tmp = &$tmp[$node];
        }

        if (null !== $previous && true === isset($node)) {
            unset($previous[$node]);
        }
    }

    /**
     * Creates a new validated data instance
     */
    private function createInstance(array $not = [], array $only = [], ?string $pluck = null): self
    {
        $instance = new static();
        $instance->data = $this->data;
        $instance->not = $not;
        $instance->only = $only;
        $instance->pluck = $pluck;

        return $instance;
    }
}
