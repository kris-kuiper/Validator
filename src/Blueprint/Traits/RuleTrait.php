<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Traits;

use KrisKuiper\Validator\Blueprint\Rules\{
    AcceptedNotEmpty,
    After,
    Before,
    Between,
    Contains,
    Count,
    CountBetween,
    CountMax,
    CountMin,
    Custom,
    Different,
    DifferentWithAll,
    Distinct,
    EndsWith,
    Equals,
    In,
    IsAccepted,
    IsAlpha,
    IsAlphaDash,
    IsAlphaNumeric,
    IsArray,
    IsBool,
    IsCountable,
    IsDate,
    IsEmail,
    IsEmpty,
    IsFalse,
    IsInt,
    IsIP,
    IsIPPrivate,
    IsIPPublic,
    IsIPv4,
    IsIPv6,
    IsJSON,
    IsMACAddress,
    IsNull,
    IsNumber,
    IsScalar,
    IsString,
    IsTimezone,
    IsTrue,
    IsURL,
    IsUUIDv1,
    IsUUIDv3,
    IsUUIDv4,
    IsUUIDv5,
    Length,
    LengthBetween,
    ContainsLetter,
    Max,
    MaxLength,
    MaxWords,
    Min,
    MinLength,
    MinWords,
    ContainsMixedCase,
    NotContains,
    NotIn,
    ContainsNumber,
    Present,
    Regex,
    Required,
    RequiredWith,
    RequiredWithAll,
    RequiredWithout,
    RequiredWithoutAll,
    Same,
    StartsNotWith,
    StartsWith,
    ContainsSymbol,
    Words
};
use KrisKuiper\Validator\Exceptions\ValidatorException;

trait RuleTrait
{
    /**
     * Checks if the data under validation is accepted if another fields value is not empty
     */
    public function acceptedNotEmpty(string $fieldName, array $accepted = []): self
    {
        return $this->addRule(new AcceptedNotEmpty($fieldName, $accepted));
    }

    /**
     * Checks if the data under validation comes after a given date
     * @throws ValidatorException
     */
    public function after(string $date, string $format = 'Y-m-d'): self
    {
        return $this->addRule(new After($date, $format));
    }

    /**
     * Checks if the data under validation comes before a given date
     * @throws ValidatorException
     */
    public function before(string $date, string $format = 'Y-m-d'): self
    {
        return $this->addRule(new Before($date, $format));
    }

    /**
     * Checks if the data under validation (number) is between a given minimum and maximum
     */
    public function between(float $minimum, float $maximum): self
    {
        return $this->addRule(new Between($minimum, $maximum));
    }

    /**
     * Checks if the data under validation contains a given value
     */
    public function contains(string|int|float $value, bool $caseSensitive = false): self
    {
        return $this->addRule(new Contains($value, $caseSensitive));
    }

    /**
     * Checks if the data under validation has at least one letter
     */
    public function containsLetter(): self
    {
        return $this->addRule(new ContainsLetter());
    }

    /**
     * Checks if the data under validation has at least one uppercase and one lowercase letter
     */
    public function containsMixedCase(): self
    {
        return $this->addRule(new ContainsMixedCase());
    }

    /**
     * Checks if the data under validation has at least one number
     */
    public function containsNumber(): self
    {
        return $this->addRule(new ContainsNumber());
    }

    /**
     * Checks if the data under validation has at least one symbol
     */
    public function containsSymbol(): self
    {
        return $this->addRule(new ContainsSymbol());
    }

    /**
     * Checks if the data under validation contains a given amount of items
     */
    public function count(int $amount): self
    {
        return $this->addRule(new Count($amount));
    }

    /**
     * Checks if the data under validation contains an amount of items between a given minimum and maximum
     */
    public function countBetween(int $minimum, int $maximum): self
    {
        return $this->addRule(new CountBetween($minimum, $maximum));
    }

    /**
     * Checks if the data under validation contains no more items than a given maximum amount
     */
    public function countMax(int $maximum): self
    {
        return $this->addRule(new CountMax($maximum));
    }

    /**
     * Checks if the data under validation contains at least a given amount of items
     */
    public function countMin(int $minimum): self
    {
        return $this->addRule(new CountMin($minimum));
    }

    /**
     * Executes a custom defined rule based on a given rule name
     */
    public function custom(string $ruleName, array $parameters = []): self
    {
        return $this->addRule(new Custom($ruleName, $parameters));
    }

    /**
     * Check if the data under validation does not match one of the values of one or more fields
     */
    public function different(string|int|float ...$fieldNames): self
    {
        return $this->addRule(new Different(...$fieldNames));
    }

    /**
     * Check if the data under validation does not match all the values of one or more fields
     */
    public function differentWithAll(string|int|float ...$fieldNames): self
    {
        return $this->addRule(new DifferentWithAll(...$fieldNames));
    }

    /**
     * Check if all the values in an array are unique
     */
    public function distinct(): self
    {
        return $this->addRule(new Distinct());
    }

    /**
     * Checks if the data under validation ends with a given value
     */
    public function endsWith(string|int|float $value, bool $caseSensitive = false): self
    {
        return $this->addRule(new EndsWith($value, $caseSensitive));
    }

    /**
     * Checks if the data under validation equals a provided value
     */
    public function equals($value, bool $strict = false): self
    {
        return $this->addRule(new Equals($value, $strict));
    }

    /**
     * Checks if the data under validation exists in a given array
     */
    public function in(array $collection, bool $strict = false): self
    {
        return $this->addRule(new In($collection, $strict));
    }

    /**
     * Checks if the data under validation is an array
     */
    public function isArray(): self
    {
        return $this->addRule(new IsArray());
    }

    /**
     * Checks if the data under validation is accepted
     */
    public function isAccepted(array $accepted = []): self
    {
        return $this->addRule(new IsAccepted($accepted));
    }

    /**
     * Checks if value only contains alpha characters
     */
    public function isAlpha(): self
    {
        return $this->addRule(new IsAlpha());
    }

    /**
     * Checks if value only contains letters and numbers, dashes and underscores
     */
    public function isAlphaDash(): self
    {
        return $this->addRule(new IsAlphaDash());
    }

    /**
     * Checks if value only exists off letters and numbers
     */
    public function isAlphaNumeric(): self
    {
        return $this->addRule(new IsAlphaNumeric());
    }

    /**
     * Checks if the data under validation is a boolean
     */
    public function isBool(): self
    {
        return $this->addRule(new IsBool());
    }

    /**
     * Checks if the data under validation is countable
     */
    public function isCountable(): self
    {
        return $this->addRule(new IsCountable());
    }

    /**
     * Checks if the data under validation is a valid date
     */
    public function isDate(string $format = 'Y-m-d'): self
    {
        return $this->addRule(new IsDate($format));
    }

    /**
     * Checks if the data under validation is a valid email address
     */
    public function isEmail(): self
    {
        return $this->addRule(new IsEmail());
    }

    /**
     * Checks if the data under validation is empty. Empty string, empty array and null are considered empty.
     */
    public function isEmpty(): self
    {
        return $this->addRule(new IsEmpty());
    }

    /**
     * Checks if the data under validation is boolean false
     */
    public function isFalse(): self
    {
        return $this->addRule(new IsFalse());
    }

    /**
     * Checks if the data under validation is an integer number
     */
    public function isInt(bool $strict = false): self
    {
        return $this->addRule(new IsInt($strict));
    }

    /**
     * Checks if the data under validation is a valid IP address (v4 or v6)
     */
    public function isIP(): self
    {
        return $this->addRule(new IsIP());
    }

    /**
     * Checks if the data under validation is a private ip address (v4 or v6)
     */
    public function isIPPrivate(): self
    {
        return $this->addRule(new IsIPPrivate());
    }

    /**
     * Checks if the data under validation is a public ip address (v4 or v6)
     */
    public function isIPPublic(): self
    {
        return $this->addRule(new IsIPPublic());
    }

    /**
     * Checks if the data under validation is a valid IP V4 address
     */
    public function isIPv4(): self
    {
        return $this->addRule(new IsIPv4());
    }

    /**
     * Checks if the data under validation is a valid IP V6 address
     */
    public function isIPv6(): self
    {
        return $this->addRule(new IsIPv6());
    }

    /**
     * Checks if the data under validation is valid JSON
     */
    public function isJSON(): self
    {
        return $this->addRule(new IsJSON());
    }

    /**
     * Checks if the data under validation is a valid MAC Address
     */
    public function isMACAddress(string $delimiter = '-'): self
    {
        return $this->addRule(new IsMACAddress($delimiter));
    }

    /**
     * Checks if the data under validation is null
     */
    public function isNull(): self
    {
        return $this->addRule(new IsNull());
    }

    /**
     * Checks if the data under validation is an integer number
     */
    public function isNumber(bool $strict = false): self
    {
        return $this->addRule(new IsNumber($strict));
    }

    /**
     * Checks if the data under validation is a scalar type
     */
    public function isScalar(): self
    {
        return $this->addRule(new IsScalar());
    }

    /**
     * Checks if the data under validation is of the type string
     */
    public function isString(): self
    {
        return $this->addRule(new IsString());
    }

    /**
     * Checks if the data under validation is a valid timezone
     * See https://www.php.net/manual/en/datetimezone.listidentifiers.php for more details
     */
    public function isTimezone(bool $caseInsensitive = false): self
    {
        return $this->addRule(new IsTimezone($caseInsensitive));
    }

    /**
     * Checks if value equals boolean true
     */
    public function isTrue(): self
    {
        return $this->addRule(new IsTrue());
    }

    /**
     * Checks if the data under validation is a valid URL
     */
    public function isURL(bool $protocol = false): self
    {
        return $this->addRule(new IsURL($protocol));
    }

    /**
     * Checks if the data under validation is a valid UUID v1 entity
     */
    public function isUUIDv1(): self
    {
        return $this->addRule(new IsUUIDv1());
    }

    /**
     * Checks if the data under validation is a valid UUID v3 entity
     */
    public function isUUIDv3(): self
    {
        return $this->addRule(new IsUUIDv3());
    }

    /**
     * Checks if the data under validation is a valid UUID v4 entity
     */
    public function isUUIDv4(): self
    {
        return $this->addRule(new IsUUIDv4());
    }

    /**
     * Checks if the data under validation is a valid UUID v4 entity
     */
    public function isUUIDv5(): self
    {
        return $this->addRule(new IsUUIDv5());
    }

    /**
     * Checks if the value character length is the given length
     */
    public function length(int $characters): self
    {
        return $this->addRule(new Length($characters));
    }

    /**
     * Checks if the data under validation is a valid URL
     */
    public function lengthBetween(int $minimum, int $maximum): self
    {
        return $this->addRule(new LengthBetween($minimum, $maximum));
    }

    /**
     * Checks if the value is less than the given maximum amount
     */
    public function max(float $maximum): self
    {
        return $this->addRule(new Max($maximum));
    }

    /**
     * Checks if the amount of characters is less or equal than the given amount
     */
    public function maxLength(int $characters): self
    {
        return $this->addRule(new MaxLength($characters));
    }

    /**
     * Checks if the amount of words is less than or equal to a given amount
     */
    public function maxWords(int $words, int $minCharacters = 2, bool $onlyAlphanumeric = true): self
    {
        return $this->addRule(new MaxWords($words, $minCharacters, $onlyAlphanumeric));
    }

    /**
     * Checks if the value is at least a given minimum
     */
    public function min(float $minimum): self
    {
        return $this->addRule(new Min($minimum));
    }

    /**
     * Checks if the amount of characters is at least a given amount
     */
    public function minLength(int $characters): self
    {
        return $this->addRule(new MinLength($characters));
    }

    /**
     * Checks if the amount of words is at least a given amount
     */
    public function minWords(int $words, int $minCharacters = 2, bool $onlyAlphanumeric = true): self
    {
        return $this->addRule(new MinWords($words, $minCharacters, $onlyAlphanumeric));
    }

    /**
     * Checks if the data under validation does not contain a given value
     */
    public function notContains($value, bool $caseSensitive = false): self
    {
        return $this->addRule(new NotContains($value, $caseSensitive));
    }

    /**
     * Checks if the data under validation does not exist in a given array
     */
    public function notIn(array $collection, bool $strict = false): self
    {
        return $this->addRule(new NotIn($collection, $strict));
    }

    /**
     * Check if the data under validation exists
     */
    public function present(): self
    {
        return $this->addRule(new Present());
    }

    /**
     * Check if value matches a regular expression pattern
     */
    public function regex(string $pattern): self
    {
        return $this->addRule(new Regex($pattern));
    }

    /**
     * Adds a new rule that will require the field/value (null, '', [] are considered null)
     */
    public function required(bool $required = true): self
    {
        return $this->addRule(new Required($required));
    }

    /**
     * Adds a new rule that will require the field/value (null, '', or []) not to be empty
     * The field under validation must be present and not empty only if one of the other specified fields are present or empty.
     */
    public function requiredWith(string ...$fieldNames): self
    {
        return $this->addRule(new RequiredWith(...$fieldNames));
    }


    /**
     * Adds a new rule that will require the field/value (null, '', or []) not to be empty
     * The field under validation must be present and not empty only if all the other specified fields are present or empty.
     */
    public function requiredWithAll(string ...$fieldNames): self
    {
        return $this->addRule(new RequiredWithAll(...$fieldNames));
    }

    /**
     * Adds a new rule that will require the field/value (null, '', or []) not to be empty
     * The field under validation must be present and not empty only if one of the other specified fields are not present or empty.
     */
    public function requiredWithout(string ...$fieldNames): self
    {
        return $this->addRule(new RequiredWithout(...$fieldNames));
    }

    /**
     * Adds a new rule that will require the field/value (null, '', or []) not to be empty
     * The field under validation must be present and not empty only if all the other specified fields are not present or empty.
     */
    public function requiredWithoutAll(string ...$fieldNames): self
    {
        return $this->addRule(new RequiredWithoutAll(...$fieldNames));
    }

    /**
     * Check if value matches a value of a given field name
     */
    public function same(string ...$fieldNames): self
    {
        return $this->addRule(new Same(...$fieldNames));
    }

    /**
     * Checks if the data under validation begins with a given value
     */
    public function startsNotWith(string|int|float $value, bool $caseSensitive = false): self
    {
        return $this->addRule(new StartsNotWith($value, $caseSensitive));
    }

    /**
     * Checks if the data under validation begins with a given value
     */
    public function startsWith(string|int|float $value, bool $caseSensitive = false): self
    {
        return $this->addRule(new StartsWith($value, $caseSensitive));
    }

    /**
     * Checks if the amount of words is at least a given amount
     */
    public function words(int $words, int $minCharacters = 2, bool $onlyAlphanumeric = true): self
    {
        return $this->addRule(new Words($words, $minCharacters, $onlyAlphanumeric));
    }
}
