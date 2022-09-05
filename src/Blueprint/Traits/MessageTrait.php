<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Traits;

use KrisKuiper\Validator\Blueprint\Messages\{
    AcceptedIf,
    AcceptedNotEmpty,
    After,
    AfterOrEqual,
    Before,
    BeforeOrEqual,
    Between,
    Contains,
    Count,
    CountBetween,
    CountMax,
    CountMin,
    Custom,
    Different,
    DifferentWithAll,
    Digits,
    DigitsBetween,
    DigitsMax,
    DigitsMin,
    Distinct,
    EndsNotWith,
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
    IsIP,
    IsIPPrivate,
    IsIPPublic,
    IsIPv4,
    IsIPv6,
    IsInt,
    IsJSON,
    IsMACAddress,
    IsNotNull,
    IsNull,
    IsNumber,
    IsScalar,
    IsString,
    IsTimezone,
    IsTrue,
    IsURL,
    IsUUID,
    IsUUIDv1,
    IsUUIDv3,
    IsUUIDv4,
    IsUUIDv5,
    Length,
    LengthBetween,
    Letters,
    Max,
    MaxLength,
    MaxWords,
    Min,
    MinLength,
    MinWords,
    MixedCase,
    NotContains,
    NotIn,
    Numbers,
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
    Symbols,
    Words
};

trait MessageTrait
{
    /**
     * Adds a new message for the acceptedIf rule
     */
    public function acceptedIf(string|int|float $message): self
    {
        return $this->addMessage(new AcceptedIf($message));
    }

    /**
     * Adds a new message for the acceptedNotEmpty rule
     */
    public function acceptedNotEmpty(string|int|float $message): self
    {
        return $this->addMessage(new AcceptedNotEmpty($message));
    }

    /**
     * Adds a new message for the after rule
     */
    public function after(string|int|float $message): self
    {
        return $this->addMessage(new After($message));
    }

    /**
     * Adds a new message for the after rule
     */
    public function afterOrEqual(string|int|float $message): self
    {
        return $this->addMessage(new AfterOrEqual($message));
    }

    /**
     * Adds a new message for the before rule
     */
    public function before(string|int|float $message): self
    {
        return $this->addMessage(new Before($message));
    }

    /**
     * Adds a new message for the beforeOrEqual rule
     */
    public function beforeOrEqual(string|int|float $message): self
    {
        return $this->addMessage(new BeforeOrEqual($message));
    }

    /**
     * Adds a new message for the between rule
     */
    public function between(string|int|float $message): self
    {
        return $this->addMessage(new Between($message));
    }

    /**
     * Adds a new message for the contains rule
     */
    public function contains(string|int|float $message): self
    {
        return $this->addMessage(new Contains($message));
    }

    /**
     * Adds a new message for the count rule
     */
    public function count(string|int|float $message): self
    {
        return $this->addMessage(new Count($message));
    }

    /**
     * Adds a new message for the countBetween rule
     */
    public function countBetween(string|int|float $message): self
    {
        return $this->addMessage(new CountBetween($message));
    }

    /**
     * Adds a new message for the countMax rule
     */
    public function countMax(string|int|float $message): self
    {
        return $this->addMessage(new CountMax($message));
    }

    /**
     * Adds a new message for the countMin rule
     */
    public function countMin(string|int|float $message): self
    {
        return $this->addMessage(new CountMin($message));
    }

    /**
     * Adds a new message for custom validation rules
     */
    public function custom(string $ruleName, string|int|float $message): self
    {
        return $this->addMessage(new Custom($ruleName, $message));
    }

    /**
     * Adds a new message for the different rule
     */
    public function different(string|int|float $message): self
    {
        return $this->addMessage(new Different($message));
    }

    /**
     * Adds a new message for the differentWithAll rule
     */
    public function differentWithAll(string|int|float $message): self
    {
        return $this->addMessage(new DifferentWithAll($message));
    }

    /**
     * Adds a new message for the digits rule
     */
    public function digits(string|int|float $message): self
    {
        return $this->addMessage(new Digits($message));
    }

    /**
     * Adds a new message for the digitsBetween rule
     */
    public function digitsBetween(string|int|float $message): self
    {
        return $this->addMessage(new DigitsBetween($message));
    }

    /**
     * Adds a new message for the distinct rule
     */
    public function distinct(string|int|float $message): self
    {
        return $this->addMessage(new Distinct($message));
    }

    /**
     * Adds a new message for the endsNotWith rule
     */
    public function endsNotWith(string|int|float $message): self
    {
        return $this->addMessage(new EndsNotWith($message));
    }

    /**
     * Adds a new message for the endsWith rule
     */
    public function endsWith(string|int|float $message): self
    {
        return $this->addMessage(new EndsWith($message));
    }

    /**
     * Adds a new message for the equals rule
     */
    public function equals(string|int|float $message): self
    {
        return $this->addMessage(new Equals($message));
    }

    /**
     * Adds a new message for the in rule
     */
    public function in(string|int|float $message): self
    {
        return $this->addMessage(new In($message));
    }

    /**
     * Adds a new message for the isAccepted rule
     */
    public function isAccepted(string|int|float $message): self
    {
        return $this->addMessage(new IsAccepted($message));
    }

    /**
     * Adds a new message for the isAlpha rule
     */
    public function isAlpha(string|int|float $message): self
    {
        return $this->addMessage(new IsAlpha($message));
    }

    /**
     * Adds a new message for the isAlphaDash rule
     */
    public function isAlphaDash(string|int|float $message): self
    {
        return $this->addMessage(new IsAlphaDash($message));
    }

    /**
     * Adds a new message for the isAlphaNumeric rule
     */
    public function isAlphaNumeric(string|int|float $message): self
    {
        return $this->addMessage(new IsAlphaNumeric($message));
    }

    /**
     * Adds a new message for the isArray rule
     */
    public function isArray(string|int|float $message): self
    {
        return $this->addMessage(new IsArray($message));
    }

    /**
     * Adds a new message for the isBool rule
     */
    public function isBool(string|int|float $message): self
    {
        return $this->addMessage(new IsBool($message));
    }

    /**
     * Adds a new message for the isCountable rule
     */
    public function isCountable(string|int|float $message): self
    {
        return $this->addMessage(new IsCountable($message));
    }

    /**
     * Adds a new message for the isDate rule
     */
    public function isDate(string|int|float $message): self
    {
        return $this->addMessage(new IsDate($message));
    }

    /**
     * Adds a new message for the isEmail rule
     */
    public function isEmail(string|int|float $message): self
    {
        return $this->addMessage(new IsEmail($message));
    }

    /**
     * Adds a new message for the isEmpty rule
     */
    public function isEmpty(string|int|float $message): self
    {
        return $this->addMessage(new IsEmpty($message));
    }

    /**
     * Adds a new message for the isFalse rule
     */
    public function isFalse(string|int|float $message): self
    {
        return $this->addMessage(new IsFalse($message));
    }

    /**
     * Adds a new message for the isIP rule
     */
    public function isIP(string|int|float $message): self
    {
        return $this->addMessage(new IsIP($message));
    }

    /**
     * Adds a new message for the isIPPrivate rule
     */
    public function isIPPrivate(string|int|float $message): self
    {
        return $this->addMessage(new IsIPPrivate($message));
    }

    /**
     * Adds a new message for the isIPPublic rule
     */
    public function isIPPublic(string|int|float $message): self
    {
        return $this->addMessage(new IsIPPublic($message));
    }

    /**
     * Adds a new message for the isIPv4 rule
     */
    public function isIPv4(string|int|float $message): self
    {
        return $this->addMessage(new IsIPv4($message));
    }

    /**
     * Adds a new message for the isIPv6 rule
     */
    public function isIPv6(string|int|float $message): self
    {
        return $this->addMessage(new IsIPv6($message));
    }

    /**
     * Adds a new message for the isInt rule
     */
    public function isInt(string|int|float $message): self
    {
        return $this->addMessage(new IsInt($message));
    }

    /**
     * Adds a new message for the isJSON rule
     */
    public function isJSON(string|int|float $message): self
    {
        return $this->addMessage(new IsJSON($message));
    }

    /**
     * Adds a new message for the isMACAddress rule
     */
    public function isMACAddress(string|int|float $message): self
    {
        return $this->addMessage(new IsMACAddress($message));
    }

    /**
     * Adds a new message for the isNumber rule
     */
    public function isNotNull(string|int|float $message): self
    {
        return $this->addMessage(new IsNotNull($message));
    }

    /**
     * Adds a new message for the isNumber rule
     */
    public function isNull(string|int|float $message): self
    {
        return $this->addMessage(new IsNull($message));
    }

    /**
     * Adds a new message for the isNumber rule
     */
    public function isNumber(string|int|float $message): self
    {
        return $this->addMessage(new IsNumber($message));
    }

    /**
     * Adds a new message for the isScalar rule
     */
    public function isScalar(string|int|float $message): self
    {
        return $this->addMessage(new IsScalar($message));
    }

    /**
     * Adds a new message for the isString rule
     */
    public function isString(string|int|float $message): self
    {
        return $this->addMessage(new IsString($message));
    }

    /**
     * Adds a new message for the isTimezone rule
     */
    public function isTimezone(string|int|float $message): self
    {
        return $this->addMessage(new IsTimezone($message));
    }

    /**
     * Adds a new message for the isTrue rule
     */
    public function isTrue(string|int|float $message): self
    {
        return $this->addMessage(new IsTrue($message));
    }

    /**
     * Adds a new message for the isURL rule
     */
    public function isURL(string|int|float $message): self
    {
        return $this->addMessage(new IsURL($message));
    }

    /**
     * Adds a new message for the isUUID rule
     */
    public function isUUID(string $message): self
    {
        return $this->addMessage(new IsUUID($message));
    }

    /**
     * Adds a new message for the isUUIDv1 rule
     */
    public function isUUIDv1(string $message): self
    {
        return $this->addMessage(new IsUUIDv1($message));
    }

    /**
     * Adds a new message for the isUUIDv3 rule
     */
    public function isUUIDv3(string $message): self
    {
        return $this->addMessage(new IsUUIDv3($message));
    }

    /**
     * Adds a new message for the isUUIDv4 rule
     */
    public function isUUIDv4(string $message): self
    {
        return $this->addMessage(new IsUUIDv4($message));
    }

    /**
     * Adds a new message for the isUUIDv5 rule
     */
    public function isUUIDv5(string $message): self
    {
        return $this->addMessage(new IsUUIDv5($message));
    }

    /**
     * Adds a new message for the length rule
     */
    public function length(string|int|float $message): self
    {
        return $this->addMessage(new Length($message));
    }

    /**
     * Adds a new message for the letters rule
     */
    public function letters(string|int|float $message): self
    {
        return $this->addMessage(new Letters($message));
    }

    /**
     * Adds a new message for the lengthBetween rule
     */
    public function lengthBetween(string|int|float $message): self
    {
        return $this->addMessage(new LengthBetween($message));
    }

    /**
     * Adds a new message for the max rule
     */
    public function max(string|int|float $message): self
    {
        return $this->addMessage(new Max($message));
    }

    /**
     * Adds a new message for the digitsMax rule
     */
    public function digitsMax(string|int|float $message): self
    {
        return $this->addMessage(new DigitsMax($message));
    }

    /**
     * Adds a new message for the maxLength rule
     */
    public function maxLength(string|int|float $message): self
    {
        return $this->addMessage(new MaxLength($message));
    }

    /**
     * Adds a new message for the maxWords rule
     */
    public function maxWords(string|int|float $message): self
    {
        return $this->addMessage(new MaxWords($message));
    }

    /**
     * Adds a new message for the min rule
     */
    public function min(string|int|float $message): self
    {
        return $this->addMessage(new Min($message));
    }

    /**
     * Adds a new message for the digitsMin rule
     */
    public function digitsMin(string|int|float $message): self
    {
        return $this->addMessage(new digitsMin($message));
    }

    /**
     * Adds a new message for the minLength rule
     */
    public function minLength(string|int|float $message): self
    {
        return $this->addMessage(new MinLength($message));
    }

    /**
     * Adds a new message for the minWords rule
     */
    public function minWords(string|int|float $message): self
    {
        return $this->addMessage(new MinWords($message));
    }

    /**
     * Adds a new message for the mixedCase rule
     */
    public function mixedCase(string|int|float $message): self
    {
        return $this->addMessage(new MixedCase($message));
    }

    /**
     * Adds a new message for the notContains rule
     */
    public function notContains(string|int|float $message): self
    {
        return $this->addMessage(new NotContains($message));
    }

    /**
     * Adds a new message for the notIn rule
     */
    public function notIn(string|int|float $message): self
    {
        return $this->addMessage(new NotIn($message));
    }

    /**
     * Adds a new message for the notIn rule
     */
    public function numbers(string|int|float $message): self
    {
        return $this->addMessage(new Numbers($message));
    }

    /**
     * Adds a new message for the present rule
     */
    public function present(string|int|float $message): self
    {
        return $this->addMessage(new Present($message));
    }

    /**
     * Adds a new message for the regex rule
     */
    public function regex(string|int|float $message): self
    {
        return $this->addMessage(new Regex($message));
    }

    /**
     * Adds a new message for the required rule
     */
    public function required(string|int|float $message): self
    {
        return $this->addMessage(new Required($message));
    }

    /**
     * Adds a new message for the required without rule
     */
    public function requiredWith(string|int|float $message): self
    {
        return $this->addMessage(new RequiredWith($message));
    }

    /**
     * Adds a new message for the requiredWithAll rule
     */
    public function requiredWithAll(string|int|float $message): self
    {
        return $this->addMessage(new RequiredWithAll($message));
    }

    /**
     * Adds a new message for the required without rule
     */
    public function requiredWithout(string|int|float $message): self
    {
        return $this->addMessage(new RequiredWithout($message));
    }

    /**
     * Adds a new message for the required without all rule
     */
    public function requiredWithoutAll(string|int|float $message): self
    {
        return $this->addMessage(new RequiredWithoutAll($message));
    }

    /**
     * Adds a new message for the same rule
     */
    public function same(string|int|float $message): self
    {
        return $this->addMessage(new Same($message));
    }

    /**
     * Adds a new message for the startsNotWith rule
     */
    public function startsNotWith(string|int|float $message): self
    {
        return $this->addMessage(new StartsNotWith($message));
    }

    /**
     * Adds a new message for the startsWith rule
     */
    public function startsWith(string|int|float $message): self
    {
        return $this->addMessage(new StartsWith($message));
    }

    /**
     * Adds a new message for the symbols rule
     */
    public function symbols(string|int|float $message): self
    {
        return $this->addMessage(new Symbols($message));
    }

    /**
     * Adds a new message for the words rule
     */
    public function words(string|int|float $message): self
    {
        return $this->addMessage(new Words($message));
    }
}
