<?php

declare(strict_types=1);

namespace KrisKuiper\Validator;

use JsonException;
use KrisKuiper\Validator\Helpers\ConvertEmpty;
use KrisKuiper\Validator\Translator\Path;
use KrisKuiper\Validator\Translator\PathTranslator;

class ValidatedData
{
    public const FILTER_EMPTY = 1;
    public const FILTER_EMPTY_ARRAYS = 2;
    public const FILTER_EMPTY_STRINGS = 4;
    public const FILTER_NULL = 8;

    private array $data = [];
    private array $not = [];
    private array $only = [];
    private int $filter = 0;
    private bool $filterRecursive = true;
    private ?string $pluck = null;
    private ?ConvertEmpty $convert = null;
    private array $template = [];

    /**
     * Excludes (blacklist) all given field names in the result set
     */
    public function not(string ...$fieldNames): self
    {
        $instance = clone $this;
        $instance->not = $fieldNames;
        return $instance;
    }

    /**
     * Includes (whitelist) all given field names in the result set
     */
    public function only(string ...$fieldNames): self
    {
        $instance = clone $this;
        $instance->only = $fieldNames;
        return $instance;
    }

    /**
     * Retrieves all the fields which matches the provided field name
     */
    public function pluck(string $fieldName): self
    {
        $instance = clone $this;
        $instance->pluck = $fieldName;
        return $instance;
    }

    public function filter(int $filter = self::FILTER_EMPTY, bool $recursive = true): self
    {
        $instance = clone $this;

        if (self::FILTER_EMPTY === $filter) {
            $filter = self::FILTER_EMPTY_ARRAYS + self::FILTER_NULL + self::FILTER_EMPTY_STRINGS;
        }

        $instance->filter = $filter;
        $instance->filterRecursive = $recursive;
        return $instance;
    }

    public function convertEmpty(mixed $convertTo = null, int $convert = ConvertEmpty::CONVERT_EMPTY, bool $recursive = true): self
    {
        $instance = clone $this;
        $instance->convert = new ConvertEmpty($convertTo, $convert, $recursive);
        return $instance;
    }

    public function template(array $template): self
    {
        $instance = clone $this;
        $instance->template = $template;
        return $instance;
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
        $output = $this->filterEmpty($output);
        $output = $this->executeConvertEmpty($output);
        $output = $this->filterTemplate($output);
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
            if (false === is_int($index) && false === is_string($index)) {
                $index = (string) $index;
            }

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
                if (null !== $keys) {
                    $this->removeFromArray($output, $keys->getPath());
                }
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
                if (null !== $keys) {
                    $this->insertIntoArray($only, $keys->getPath(), $keys->getValue());
                }
            }
        }

        return $only;
    }

    private function filterTemplate(array $output): array
    {
        if ([] === $this->template) {
            return $output;
        }

        return $this->filterTemplate2($this->template, $output);
    }


    private function filterTemplate2(array $input, array $output): array
    {
        $data = [];

        foreach ($input as $key => $value) {
            if (true === is_array($value)) {
                if (false === array_key_exists($key, $output) || false === is_array($output[$key])) {
                    continue;
                }

                $data[$key] = $this->filterTemplate2($value, $output[$key]);
            } else {
                if (false === array_key_exists($value, $output)) {
                    continue;
                }

                $data[$value] = $output[$value];
            }
        }

        return $data;
    }

    /**
     * Converts empty values i.e. empty arrays, strings or NULL values
     */
    private function executeConvertEmpty(array $output): array
    {
        if (null === $this->convert) {
            return $output;
        }

        return $this->convert->convert($output);
    }

    /**
     * Filters empty values i.e. empty arrays, strings or NULL values
     */
    private function filterEmpty(array $output): array
    {
        if (0 === $this->filter) {
            return $output;
        }

        foreach ($output as $key => $value) {
            //Check if filtering should be executed recursively
            if (true === is_array($value) && true === $this->filterRecursive) {
                $output[$key] = $this->filterEmpty($value);
            }

            if (self::FILTER_EMPTY_STRINGS & $this->filter && '' === $output[$key]) { //Check for empty string
                unset($output[$key]);
            } elseif (self::FILTER_NULL & $this->filter && null === $output[$key]) { //Check if value is null
                unset($output[$key]);
            } elseif (self::FILTER_EMPTY_ARRAYS & $this->filter && true === is_countable($output[$key]) && 0 === count($output[$key])) { //Check if empty countable i.e. array
                unset($output[$key]);
            }
        }

        return $output;
    }

    /**
     * Inserts element into a multidimensional array by giving an array path which represents the path (depth) to the value
     */
    private function insertIntoArray(array &$array, array $path, mixed $value): void
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
    private function removeFromArray(array &$array, array $path): void
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
}
