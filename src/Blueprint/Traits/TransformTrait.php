<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Traits;

use KrisKuiper\Validator\Blueprint\Middleware\Transforms\{
    ABS,
    Ceil,
    Floor,
    LeadingZero,
    LTrim,
    Replace,
    Round,
    RTrim,
    Substr,
    ToBoolean,
    ToFloat,
    ToInt,
    ToLowercase,
    ToString,
    ToUppercase,
    Trim,
    UCFirst,
    UCWords
};

trait TransformTrait
{
    /**
     * Converts the value (if it is a string) under validation to lowercase
     */
    public function toLowercase(): self
    {
        return $this->addTransform(new ToLowercase());
    }

    /**
     * Converts the value (if it is a string) under validation to uppercase
     */
    public function toUppercase(): self
    {
        return $this->addTransform(new ToUppercase());
    }

    /**
     * Converts the value under validation to a boolean
     */
    public function toBoolean(): self
    {
        return $this->addTransform(new ToBoolean());
    }

    /**
     * Converts the value under validation to an integer number
     */
    public function toInt(): self
    {
        return $this->addTransform(new ToInt());
    }

    /**
     * Converts the value under validation to a string
     */
    public function toString(): self
    {
        return $this->addTransform(new ToString());
    }

    /**
     * Converts the value under validation to a float
     */
    public function toFloat(): self
    {
        return $this->addTransform(new ToFloat());
    }

    /**
     * Converts to the next highest integer value by rounding up the value if necessary and if the value is a number
     */
    public function ceil(): self
    {
        return $this->addTransform(new Ceil());
    }

    /**
     * Converts to the next lowest integer value by rounding up the value if necessary and if the value is a number
     */
    public function floor(): self
    {
        return $this->addTransform(new Floor());
    }

    /**
     * Prefixes a zero for numbers between 0 and 9
     */
    public function leadingZero(): self
    {
        return $this->addTransform(new LeadingZero());
    }

    /**
     * Rounds the value if the value is a number
     */
    public function round(int $precision = 0, int $mode = PHP_ROUND_HALF_UP): self
    {
        return $this->addTransform(new Round(), ['precision' => $precision, 'mode' => $mode]);
    }

    /**
     * Converts numbers to the absolute value
     */
    public function abs(): self
    {
        return $this->addTransform(new ABS());
    }

    /**
     * Strips whitespace (or other characters) from the beginning and end of a string
     */
    public function trim(string $characters = " \n\r\t\v\x00"): self
    {
        return $this->addTransform(new Trim(), ['characters' => $characters]);
    }

    /**
     * Strips whitespace (or other characters) from the beginning of a string
     */
    public function ltrim(string $characters = " \n\r\t\v\x00"): self
    {
        return $this->addTransform(new LTrim(), ['characters' => $characters]);
    }

    /**
     * Strips whitespace (or other characters) from the end of a string
     */
    public function rtrim(string $characters = " \n\r\t\v\x00"): self
    {
        return $this->addTransform(new RTrim(), ['characters' => $characters]);
    }

    /**
     * Replaces all occurrences of the search string with the replacement string
     */
    public function replace(string $search, string $replace): self
    {
        return $this->addTransform(new Replace(), ['search' => $search, 'replace' => $replace]);
    }

    /**
     * Returns part of a string
     */
    public function substr(int $offset, int $length = null): self
    {
        return $this->addTransform(new Substr(), ['offset' => $offset, 'length' => $length]);
    }

    /**
     * Makes a string's first character uppercase
     */
    public function ucFirst(): self
    {
        return $this->addTransform(new UCFirst());
    }

    /**
     * Makes the first character of each word in a string uppercase
     */
    public function ucWords(): self
    {
        return $this->addTransform(new UCWords());
    }
}
