<?php

declare(strict_types=1);

namespace tests\unit\Helpers;

use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Helpers\ConvertEmpty;
use PHPUnit\Framework\TestCase;


final class ConvertEmptyTest extends TestCase
{
    public function testShouldConvertEmptyStringWhenUsingNoParameters(): void
    {
        $convertEmpty = new ConvertEmpty();
        $this->assertSame([null], $convertEmpty->convert(['']));
    }

    public function testShouldConvertEmptyArrayWhenUsingNoParameters(): void
    {
        $convertEmpty = new ConvertEmpty();
        $this->assertSame([null], $convertEmpty->convert([[]]));
    }

    public function testShouldDoNoOpOnNullWhenUsingNoParameters(): void
    {
        $convertEmpty = new ConvertEmpty();
        $this->assertSame([null], $convertEmpty->convert([null]));
    }

    public function testShouldConvertMultipleEmptyStringWhenUsingNoParameters(): void
    {
        $convertEmpty = new ConvertEmpty();
        $this->assertSame([null, null, null], $convertEmpty->convert(['', '', '']));
    }

    public function testShouldConvertMultipleEmptyObjectsWhenUsingNoParameters(): void
    {
        $convertEmpty = new ConvertEmpty();
        $this->assertSame([null, null, null], $convertEmpty->convert(['', null, []]));
    }

    public function testShouldConvertEmptyObjectToNullWhenNewValueIsProvided(): void
    {
        $convertEmpty = new ConvertEmpty(null);
        $this->assertSame([null, null, ' ', true], $convertEmpty->convert(['', '', ' ', true]));
    }

    public function testShouldConvertEmptyObjectToNewValueWhenNonDefaultValueIsProvided(): void
    {
        $convertEmpty = new ConvertEmpty('bar');
        $this->assertSame(['bar', 'bar', ' ', true], $convertEmpty->convert(['', '', ' ', true]));
    }

    public function testShouldOnlyConvertEmptyStringWhenEmptyStringModeIsProvided(): void
    {
        $convertEmpty = new ConvertEmpty(mode: ConvertEmpty::CONVERT_EMPTY_STRING);
        $this->assertSame([null, null, ' ', [], null, true], $convertEmpty->convert(['', '', ' ', [], null, true]));
    }

    public function testShouldOnlyConvertEmptyArraysWhenEmptyArrayModeIsProvided(): void
    {
        $convertEmpty = new ConvertEmpty(mode: ConvertEmpty::CONVERT_EMPTY_ARRAY);
        $this->assertSame(['', '', ' ', null, true], $convertEmpty->convert(['', '', ' ', [], true]));
    }

    public function testIfOnlyNullValuesAreConvertedWhenUsingEmptyNullMode(): void
    {
        $convertEmpty = new ConvertEmpty(mode: ConvertEmpty::CONVERT_NULL);
        $this->assertSame(['', '', ' ', null, true], $convertEmpty->convert(['', '', ' ', null, true]));
    }

    public function testIfValueOfKeyIsConvertedWhenThreeDimensionalArrayIsProvided(): void
    {
        $convertEmpty = new ConvertEmpty();
        $this->assertSame(['foo' => null], $convertEmpty->convert(['foo' => []]));
    }

    public function testIfValueOfKeyIsConvertedWhenNestedArrayIsProvided(): void
    {
        $convertEmpty = new ConvertEmpty();
        $this->assertSame(['foo' => ['bar' => ['quez' => null]]], $convertEmpty->convert(['foo' => ['bar' => ['quez' => '']]]));
    }

    public function testIfValueOfKeyIsNotConvertedWhenRecursiveIsDisabled(): void
    {
        $convertEmpty = new ConvertEmpty(recursive: false);
        $this->assertSame(['foo' => ['bar' => ['quez' => '']]], $convertEmpty->convert(['foo' => ['bar' => ['quez' => '']]]));
    }

    /**
     * @throws ValidatorException
     */
    public function testIfExceptionIsThrownWhenUsingIncorrectConvertMode(): void
    {
        $this->expectException(ValidatorException::class);
        new ConvertEmpty(mode: -5);
    }
}