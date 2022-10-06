<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Traits;

use KrisKuiper\Validator\Blueprint\Rules\{
    Accepted,
    AcceptedIf,
    AcceptedNotEmpty,
    After,
    AfterOrEqual,
    Alpha,
    AlphaDash,
    AlphaNumeric,
    Before,
    BeforeOrEqual,
    Between,
    Contains,
    ContainsLetter,
    ContainsMixedCase,
    ContainsNot,
    ContainsDigit,
    ContainsSymbol,
    Count,
    Countable,
    CountBetween,
    CountMax,
    CountMin,
    CSSColor,
    Date,
    DateBetween,
    Different,
    DifferentWithAll,
    Digits,
    DigitsBetween,
    DigitsMax,
    DigitsMin,
    Distinct,
    DivisibleBy,
    Email,
    EndsNotWith,
    EndsWith,
    Equals,
    Hexadecimal,
    In,
    IP,
    IPPrivate,
    IPPublic,
    IPv4,
    IPv6,
    IsArray,
    IsBool,
    IsEmpty,
    IsFalse,
    IsInt,
    IsNotNull,
    IsNull,
    IsString,
    IsTrue,
    JSON,
    Length,
    LengthBetween,
    LengthMax,
    LengthMin,
    MACAddress,
    Max,
    Min,
    Negative,
    NegativeOrZero,
    NotIn,
    Number,
    Positive,
    PositiveOrZero,
    Present,
    Regex,
    Required,
    RequiredWith,
    RequiredWithAll,
    RequiredWithout,
    RequiredWithoutAll,
    Same,
    Scalar,
    StartsNotWith,
    StartsWith,
    Timezone,
    URL,
    UUID,
    UUIDv1,
    UUIDv3,
    UUIDv4,
    UUIDv5,
    Words,
    WordsMax,
    WordsMin,
};
use KrisKuiper\Validator\Exceptions\ValidatorException;

trait RuleTrait
{
    /**
     * Checks if the data under validation is accepted
     */
    public function accepted(array $accepted = []): self
    {
        return $this->addRule(new Accepted($accepted));
    }

    /**
     * Checks if the data under validation is accepted if another field under validation is equal to a specified value
     */
    public function acceptedIf(string $fieldName, mixed $value, array $accepted = []): self
    {
        return $this->addRule(new AcceptedIf($fieldName, $value, $accepted));
    }

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
     * Checks if the data under validation comes after or is equal to a given date
     * @throws ValidatorException
     */
    public function afterOrEqual(string $date, string $format = 'Y-m-d'): self
    {
        return $this->addRule(new AfterOrEqual($date, $format));
    }

    /**
     * Checks if value only contains alpha characters
     */
    public function alpha(): self
    {
        return $this->addRule(new Alpha());
    }

    /**
     * Checks if value only contains letters and numbers, dashes and underscores
     */
    public function alphaDash(): self
    {
        return $this->addRule(new AlphaDash());
    }

    /**
     * Checks if value only exists off letters and numbers
     */
    public function alphaNumeric(): self
    {
        return $this->addRule(new AlphaNumeric());
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
     * Checks if the data under validation comes before or equal to a given date
     * @throws ValidatorException
     */
    public function beforeOrEqual(string $date, string $format = 'Y-m-d'): self
    {
        return $this->addRule(new BeforeOrEqual($date, $format));
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
     * Checks if the data under validation does not contain a given value
     */
    public function containsNot(string|int|float $value, bool $caseSensitive = false): self
    {
        return $this->addRule(new ContainsNot($value, $caseSensitive));
    }

    /**
     * Checks if the data under validation has at least a provided amount of letters
     */
    public function containsLetter(int $minimumLettersCount = 1): self
    {
        return $this->addRule(new ContainsLetter($minimumLettersCount));
    }

    /**
     * Checks if the data under validation has at least a provided amount of uppercase and lowercase letters
     */
    public function containsMixedCase(int $minimumLowercaseCount = 1, int $minimumUppercaseCount = 1): self
    {
        return $this->addRule(new ContainsMixedCase($minimumLowercaseCount, $minimumUppercaseCount));
    }

    /**
     * Checks if the data under validation has at least a provided amount of digits
     */
    public function containsDigit(int $minimumDigitCount = 1): self
    {
        return $this->addRule(new ContainsDigit($minimumDigitCount));
    }

    /**
     * Checks if the data under validation has at least a provided amount of symbols
     */
    public function containsSymbol(int $minimumSymbolsCount = 1): self
    {
        return $this->addRule(new ContainsSymbol($minimumSymbolsCount));
    }

    /**
     * Checks if the data under validation contains a given amount of items
     */
    public function count(int $amount): self
    {
        return $this->addRule(new Count($amount));
    }

    /**
     * Checks if the data under validation is countable
     */
    public function countable(): self
    {
        return $this->addRule(new Countable());
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
     * Checks if the data under validation is a valid CSS color
     */
    public function cssColor(bool $requireHash = false, bool $shortcodesSupport = true): self
    {
        return $this->addRule(new CSSColor($requireHash, $shortcodesSupport));
    }

    /**
     * Checks if the data under validation is a valid date
     */
    public function date(string $format = 'Y-m-d'): self
    {
        return $this->addRule(new Date($format));
    }

    /**
     * Checks if the data under validation is between a provided from and to date
     * @throws ValidatorException
     */
    public function dateBetween(string $from, string $to, string $format = 'Y-m-d'): self
    {
        return $this->addRule(new DateBetween($from, $to, $format));
    }

    /**
     * Checks if the data under validation does not match one of the values of one or more fields
     */
    public function different(string|int|float ...$fieldNames): self
    {
        return $this->addRule(new Different(...$fieldNames));
    }

    /**
     * Checks if the data under validation does not match all the values of one or more fields
     */
    public function differentWithAll(string|int ...$fieldNames): self
    {
        return $this->addRule(new DifferentWithAll(...$fieldNames));
    }

    /**
     * Checks if an integer value have exact length of provided digits
     */
    public function digits(int $digits): self
    {
        return $this->addRule(new Digits($digits));
    }

    /**
     * Checks if an integer value is between the provided min and max length of digits
     */
    public function digitsBetween(int $min, int $max): self
    {
        return $this->addRule(new DigitsBetween($min, $max));
    }

    /**
     * Checks if an integer value has a maximum length of digits
     */
    public function digitsMax(int $max): self
    {
        return $this->addRule(new DigitsMax($max));
    }

    /**
     * Checks if an integer value has at least the provided length of digits
     */
    public function digitsMin(int $min): self
    {
        return $this->addRule(new DigitsMin($min));
    }

    /**
     * Checks if all the values in an array are unique
     */
    public function distinct(): self
    {
        return $this->addRule(new Distinct());
    }

    /**
     * Checks if the value under validation is divisible by a provided number
     */
    public function divisibleBy(float $number, bool $strict = false): self
    {
        return $this->addRule(new DivisibleBy($number, $strict));
    }

    /**
     * Checks if the data under validation is a valid email address
     */
    public function email(): self
    {
        return $this->addRule(new Email());
    }

    /**
     * Checks if the data under validation does not end with a given value
     */
    public function endsNotWith(string|int|float $value, bool $caseSensitive = false): self
    {
        return $this->addRule(new EndsNotWith($value, $caseSensitive));
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
    public function equals(mixed $value, bool $strict = false): self
    {
        return $this->addRule(new Equals($value, $strict));
    }

    /**
     * Checks if the data under validation is a valid hexadecimal value
     */
    public function hexadecimal(): self
    {
        return $this->addRule(new Hexadecimal());
    }

    /**
     * Checks if the data under validation exists in a given array
     */
    public function in(array $collection, bool $strict = false): self
    {
        return $this->addRule(new In($collection, $strict));
    }

    /**
     * Checks if the data under validation is a valid IP address (v4 or v6)
     */
    public function ip(): self
    {
        return $this->addRule(new IP());
    }

    /**
     * Checks if the data under validation is a private ip address (v4 or v6)
     */
    public function ipPrivate(): self
    {
        return $this->addRule(new IPPrivate());
    }

    /**
     * Checks if the data under validation is a public ip address (v4 or v6)
     */
    public function ipPublic(): self
    {
        return $this->addRule(new IPPublic());
    }

    /**
     * Checks if the data under validation is a valid IP V4 address
     */
    public function ipv4(): self
    {
        return $this->addRule(new IPv4());
    }

    /**
     * Checks if the data under validation is a valid IP V6 address
     */
    public function ipv6(): self
    {
        return $this->addRule(new IPv6());
    }

    /**
     * Checks if the data under validation is an array
     */
    public function isArray(): self
    {
        return $this->addRule(new IsArray());
    }

    /**
     * Checks if the data under validation is a boolean
     */
    public function isBool(): self
    {
        return $this->addRule(new IsBool());
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
     * Checks if the data under validation is not null
     */
    public function isNotNull(): self
    {
        return $this->addRule(new IsNotNull());
    }

    /**
     * Checks if the data under validation is null
     */
    public function isNull(): self
    {
        return $this->addRule(new IsNull());
    }

    /**
     * Checks if the data under validation is of the type string
     */
    public function isString(): self
    {
        return $this->addRule(new IsString());
    }

    /**
     * Checks if value equals boolean true
     */
    public function isTrue(): self
    {
        return $this->addRule(new IsTrue());
    }

    /**
     * Checks if the data under validation is valid JSON
     */
    public function json(): self
    {
        return $this->addRule(new JSON());
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
     * Checks if the amount of characters is less or equal than the given amount
     */
    public function lengthMax(int $characters): self
    {
        return $this->addRule(new LengthMax($characters));
    }

    /**
     * Checks if the amount of characters is at least a given amount
     */
    public function lengthMin(int $characters): self
    {
        return $this->addRule(new LengthMin($characters));
    }

    /**
     * Checks if the data under validation is a valid MAC Address
     */
    public function macAddress(string $delimiter = '-'): self
    {
        return $this->addRule(new MACAddress($delimiter));
    }

    /**
     * Checks if the value is less than the given maximum amount
     */
    public function max(float $maximum): self
    {
        return $this->addRule(new Max($maximum));
    }

    /**
     * Checks if the value is at least a given minimum
     */
    public function min(float $minimum): self
    {
        return $this->addRule(new Min($minimum));
    }

    /**
     * Checks if the data under validation is a negative number
     */
    public function negative(bool $strict = false): self
    {
        return $this->addRule(new Negative($strict));
    }

    /**
     * Checks if the data under validation is equals to zero or below
     */
    public function negativeOrZero(bool $strict = false): self
    {
        return $this->addRule(new NegativeOrZero($strict));
    }

    /**
     * Checks if the data under validation does not exist in a given array
     */
    public function notIn(array $collection, bool $strict = false): self
    {
        return $this->addRule(new NotIn($collection, $strict));
    }

    /**
     * Checks if the data under validation is an integer or float number
     */
    public function number(bool $strict = false): self
    {
        return $this->addRule(new Number($strict));
    }

    /**
     * Checks if the data under validation is a positive number
     */
    public function positive(bool $strict = false): self
    {
        return $this->addRule(new Positive($strict));
    }

    /**
     * Checks if the data under validation is higher or equal to zero
     */
    public function positiveOrZero(bool $strict = false): self
    {
        return $this->addRule(new PositiveOrZero($strict));
    }

    /**
     * Checks if the data under validation exists
     */
    public function present(): self
    {
        return $this->addRule(new Present());
    }

    /**
     * Checks if data under validation matches a regular expression pattern
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
     * Checks if value matches a value of a given field name
     */
    public function same(string ...$fieldNames): self
    {
        return $this->addRule(new Same(...$fieldNames));
    }

    /**
     * Checks if the data under validation is a scalar type
     */
    public function scalar(): self
    {
        return $this->addRule(new Scalar());
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
     * Checks if the data under validation is a valid timezone
     * See https://www.php.net/manual/en/datetimezone.listidentifiers.php for more details
     */
    public function timezone(bool $caseInsensitive = false): self
    {
        return $this->addRule(new Timezone($caseInsensitive));
    }

    /**
     * Checks if the data under validation is a valid URL
     */
    public function url(bool $protocol = false): self
    {
        return $this->addRule(new URL($protocol));
    }

    /**
     * Checks if the data under validation is a valid UUID v1, v3, v4 or v5 entity
     */
    public function uuid(): self
    {
        return $this->addRule(new UUID());
    }

    /**
     * Checks if the data under validation is a valid UUID v1 entity
     */
    public function uuidv1(): self
    {
        return $this->addRule(new UUIDv1());
    }

    /**
     * Checks if the data under validation is a valid UUID v3 entity
     */
    public function uuidv3(): self
    {
        return $this->addRule(new UUIDv3());
    }

    /**
     * Checks if the data under validation is a valid UUID v4 entity
     */
    public function uuidv4(): self
    {
        return $this->addRule(new UUIDv4());
    }

    /**
     * Checks if the data under validation is a valid UUID v4 entity
     */
    public function uuidv5(): self
    {
        return $this->addRule(new UUIDv5());
    }

    /**
     * Checks if the amount of words is at least a given amount
     */
    public function words(int $words, int $minCharacters = 2, bool $onlyAlphanumeric = true): self
    {
        return $this->addRule(new Words($words, $minCharacters, $onlyAlphanumeric));
    }

    /**
     * Checks if the amount of words is less than or equal to a given amount
     */
    public function wordsMax(int $words, int $minCharacters = 2, bool $onlyAlphanumeric = true): self
    {
        return $this->addRule(new WordsMax($words, $minCharacters, $onlyAlphanumeric));
    }

    /**
     * Checks if the amount of words is at least a given amount
     */
    public function wordsMin(int $words, int $minCharacters = 2, bool $onlyAlphanumeric = true): self
    {
        return $this->addRule(new WordsMin($words, $minCharacters, $onlyAlphanumeric));
    }
}
