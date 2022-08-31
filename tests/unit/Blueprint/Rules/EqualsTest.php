<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class EqualsTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenComparingSameStrings(): void
    {
        $validator = new Validator(['field' => 'test']);
        $validator->field('field')->equals('test');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenComparingSameArrays(): void
    {
        $validator = new Validator(['field' => ['foo' => 'bar', 'quez' => 'qwaz']]);
        $validator->field('field')->equals(['quez' => 'qwaz', 'foo' => 'bar']);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenComparingSameArraysStrictly(): void
    {
        $validator = new Validator(['field' => ['foo' => 'bar', 'quez' => 'qwaz']]);
        $validator->field('field')->equals(['foo' => 'bar', 'quez' => 'qwaz'], true);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldFailValidationWhenComparingArraysIndifferentOrderStrictly(): void
    {
        $validator = new Validator(['field' => ['foo' => 'bar', 'quez' => 'qwaz']]);
        $validator->field('field')->equals(['quez' => 'qwaz', 'foo' => 'bar'], true);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenComparingStringWithIntNonStrictly(): void
    {
        $validator = new Validator(['field' => 1]);
        $validator->field('field')->equals('1');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldFailValidationWhenComparingStringWithIntStrictly(): void
    {
        $validator = new Validator(['field' => 1]);
        $validator->field('field')->equals('1', true);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenComparingIntWithBooleanNonStrictly(): void
    {
        $validator = new Validator(['field' => 1]);
        $validator->field('field')->equals(true);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldFailValidationWhenComparingIntWithBooleanStrictly(): void
    {
        $validator = new Validator(['field' => 1]);
        $validator->field('field')->equals(true, true);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldFailValidationWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->equals('foo');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldReturnCorrectMessageWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => 'foo']);
        $validator->field('field')->equals('bar');
        $validator->messages('field')->equals('Message equals');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message equals', $validator->errors()->first('field')->getMessage());
    }
}
