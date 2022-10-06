<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Traits;

use KrisKuiper\Validator\Blueprint\Messages\{
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
    Custom,
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

trait MessageTrait
{
    /**
     * Adds a new message for the accepted rule
     */
    public function accepted(string|int|float $message): self
    {
        return $this->addMessage(new Accepted($message));
    }

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
     * Adds a new message for the Alpha rule
     */
    public function alpha(string|int|float $message): self
    {
        return $this->addMessage(new Alpha($message));
    }

    /**
     * Adds a new message for the alphaDash rule
     */
    public function alphaDash(string|int|float $message): self
    {
        return $this->addMessage(new AlphaDash($message));
    }

    /**
     * Adds a new message for the alphaNumeric rule
     */
    public function alphaNumeric(string|int|float $message): self
    {
        return $this->addMessage(new AlphaNumeric($message));
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
     * Adds a new message for the containsNot rule
     */
    public function containsNot(string|int|float $message): self
    {
        return $this->addMessage(new ContainsNot($message));
    }

    /**
     * Adds a new message for the containsLetter rule
     */
    public function containsLetter(string|int|float $message): self
    {
        return $this->addMessage(new ContainsLetter($message));
    }

    /**
     * CAdds a new message for the containsMixedCase rule
     */
    public function containsMixedCase(string|int|float $message): self
    {
        return $this->addMessage(new ContainsMixedCase($message));
    }

    /**
     * Adds a new message for the containsDigit rule
     */
    public function containsDigit(string|int|float $message): self
    {
        return $this->addMessage(new ContainsDigit($message));
    }

    /**
     * Adds a new message for the containsSymbol rule
     */
    public function containsSymbol(string|int|float $message): self
    {
        return $this->addMessage(new ContainsSymbol($message));
    }

    /**
     * Adds a new message for the count rule
     */
    public function count(string|int|float $message): self
    {
        return $this->addMessage(new Count($message));
    }

    /**
     * Adds a new message for the countable rule
     */
    public function countable(string|int|float $message): self
    {
        return $this->addMessage(new Countable($message));
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
     * Adds a new message for the cssColor rule
     */
    public function cssColor(string|int|float $message): self
    {
        return $this->addMessage(new CSSColor($message));
    }

    /**
     * Adds a new message for custom validation rules
     */
    public function custom(string $ruleName, string|int|float $message): self
    {
        return $this->addMessage(new Custom($ruleName, $message));
    }

    /**
     * Adds a new message for the date rule
     */
    public function date(string|int|float $message): self
    {
        return $this->addMessage(new Date($message));
    }

    /**
     * Adds a new message for the dateBetween rule
     */
    public function dateBetween(string|int|float $message): self
    {
        return $this->addMessage(new DateBetween($message));
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
     * Adds a new message for the digitsMax rule
     */
    public function digitsMax(string|int|float $message): self
    {
        return $this->addMessage(new DigitsMax($message));
    }

    /**
     * Adds a new message for the digitsMin rule
     */
    public function digitsMin(string|int|float $message): self
    {
        return $this->addMessage(new digitsMin($message));
    }

    /**
     * Adds a new message for the distinct rule
     */
    public function distinct(string|int|float $message): self
    {
        return $this->addMessage(new Distinct($message));
    }

    /**
     * Adds a new message for the divisibleBy rule
     */
    public function divisibleBy(string|int|float $message): self
    {
        return $this->addMessage(new DivisibleBy($message));
    }

    /**
     * Adds a new message for the email rule
     */
    public function email(string|int|float $message): self
    {
        return $this->addMessage(new Email($message));
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
     * Adds a new message for the hexadecimal rule
     */
    public function hexadecimal(string|int|float $message): self
    {
        return $this->addMessage(new Hexadecimal($message));
    }

    /**
     * Adds a new message for the ip rule
     */
    public function ip(string|int|float $message): self
    {
        return $this->addMessage(new IP($message));
    }

    /**
     * Adds a new message for the ipPrivate rule
     */
    public function ipPrivate(string|int|float $message): self
    {
        return $this->addMessage(new IPPrivate($message));
    }

    /**
     * Adds a new message for the ipPublic rule
     */
    public function ipPublic(string|int|float $message): self
    {
        return $this->addMessage(new IPPublic($message));
    }

    /**
     * Adds a new message for the ipv4 rule
     */
    public function ipv4(string|int|float $message): self
    {
        return $this->addMessage(new IPv4($message));
    }

    /**
     * Adds a new message for the ipv6 rule
     */
    public function ipv6(string|int|float $message): self
    {
        return $this->addMessage(new IPv6($message));
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
     * Adds a new message for the isInt rule
     */
    public function isInt(string|int|float $message): self
    {
        return $this->addMessage(new IsInt($message));
    }

    /**
     * Adds a new message for the isNotNull rule
     */
    public function isNotNull(string|int|float $message): self
    {
        return $this->addMessage(new IsNotNull($message));
    }

    /**
     * Adds a new message for the isNull rule
     */
    public function isNull(string|int|float $message): self
    {
        return $this->addMessage(new IsNull($message));
    }

    /**
     * Adds a new message for the isString rule
     */
    public function isString(string|int|float $message): self
    {
        return $this->addMessage(new IsString($message));
    }

    /**
     * Adds a new message for the isTrue rule
     */
    public function isTrue(string|int|float $message): self
    {
        return $this->addMessage(new IsTrue($message));
    }

    /**
     * Adds a new message for the json rule
     */
    public function json(string|int|float $message): self
    {
        return $this->addMessage(new JSON($message));
    }

    /**
     * Adds a new message for the length rule
     */
    public function length(string|int|float $message): self
    {
        return $this->addMessage(new Length($message));
    }

    /**
     * Adds a new message for the lengthBetween rule
     */
    public function lengthBetween(string|int|float $message): self
    {
        return $this->addMessage(new LengthBetween($message));
    }

    /**
     * Adds a new message for the lengthMax rule
     */
    public function lengthMax(string|int|float $message): self
    {
        return $this->addMessage(new LengthMax($message));
    }

    /**
     * Adds a new message for the lengthMin rule
     */
    public function lengthMin(string|int|float $message): self
    {
        return $this->addMessage(new LengthMin($message));
    }

    /**
     * Adds a new message for the macAddress rule
     */
    public function macAddress(string|int|float $message): self
    {
        return $this->addMessage(new MACAddress($message));
    }

    /**
     * Adds a new message for the max rule
     */
    public function max(string|int|float $message): self
    {
        return $this->addMessage(new Max($message));
    }

    /**
     * Adds a new message for the min rule
     */
    public function min(string|int|float $message): self
    {
        return $this->addMessage(new Min($message));
    }

    /**
     * Adds a new message for the negative rule
     */
    public function negative(string|int|float $message): self
    {
        return $this->addMessage(new Negative($message));
    }

    /**
     * Adds a new message for the negativeOrZero rule
     */
    public function negativeOrZero(string|int|float $message): self
    {
        return $this->addMessage(new NegativeOrZero($message));
    }

    /**
     * Adds a new message for the notIn rule
     */
    public function notIn(string|int|float $message): self
    {
        return $this->addMessage(new NotIn($message));
    }

    /**
     * Adds a new message for the number rule
     */
    public function number(string|int|float $message): self
    {
        return $this->addMessage(new Number($message));
    }

    /**
     * Adds a new message for the positive rule
     */
    public function positive(string|int|float $message): self
    {
        return $this->addMessage(new Positive($message));
    }

    /**
     * Adds a new message for the positiveOrZero rule
     */
    public function positiveOrZero(string|int|float $message): self
    {
        return $this->addMessage(new PositiveOrZero($message));
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
     * Adds a new message for the scalar rule
     */
    public function scalar(string|int|float $message): self
    {
        return $this->addMessage(new Scalar($message));
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
     * Adds a new message for the timezone rule
     */
    public function timezone(string|int|float $message): self
    {
        return $this->addMessage(new Timezone($message));
    }

    /**
     * Adds a new message for the url rule
     */
    public function url(string|int|float $message): self
    {
        return $this->addMessage(new URL($message));
    }

    /**
     * Adds a new message for the uuid rule
     */
    public function uuid(string $message): self
    {
        return $this->addMessage(new UUID($message));
    }

    /**
     * Adds a new message for the uuidv1 rule
     */
    public function uuidv1(string $message): self
    {
        return $this->addMessage(new UUIDv1($message));
    }

    /**
     * Adds a new message for the uuidv3 rule
     */
    public function uuidv3(string $message): self
    {
        return $this->addMessage(new UUIDv3($message));
    }

    /**
     * Adds a new message for the uuidv4 rule
     */
    public function uuidv4(string $message): self
    {
        return $this->addMessage(new UUIDv4($message));
    }

    /**
     * Adds a new message for the uuidv5 rule
     */
    public function uuidv5(string $message): self
    {
        return $this->addMessage(new UUIDv5($message));
    }

    /**
     * Adds a new message for the words rule
     */
    public function words(string|int|float $message): self
    {
        return $this->addMessage(new Words($message));
    }

    /**
     * Adds a new message for the wordsMax rule
     */
    public function wordsMax(string|int|float $message): self
    {
        return $this->addMessage(new WordsMax($message));
    }

    /**
     * Adds a new message for the wordsMin rule
     */
    public function wordsMin(string|int|float $message): self
    {
        return $this->addMessage(new WordsMin($message));
    }
}
