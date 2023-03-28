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
    public function testIfValidationPassesWhenComparingSameStrings(): void
    {
        $validator = new Validator(['field' => 'test']);
        $validator->field('field')->equals('test');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenComparingSameArrays(): void
    {
        $validator = new Validator(['field' => ['foo' => 'bar', 'quez' => 'qwaz']]);
        $validator->field('field')->equals(['quez' => 'qwaz', 'foo' => 'bar']);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenComparingSameArraysStrictly(): void
    {
        $validator = new Validator(['field' => ['foo' => 'bar', 'quez' => 'qwaz']]);
        $validator->field('field')->equals(['foo' => 'bar', 'quez' => 'qwaz'], true);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenComparingArraysIndifferentOrderStrictly(): void
    {
        $validator = new Validator(['field' => ['foo' => 'bar', 'quez' => 'qwaz']]);
        $validator->field('field')->equals(['quez' => 'qwaz', 'foo' => 'bar'], true);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenComparingStringWithIntNonStrictly(): void
    {
        $validator = new Validator(['field' => 1]);
        $validator->field('field')->equals('1');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenComparingStringWithIntStrictly(): void
    {
        $validator = new Validator(['field' => 1]);
        $validator->field('field')->equals('1', true);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenComparingIntWithBooleanNonStrictly(): void
    {
        $validator = new Validator(['field' => 1]);
        $validator->field('field')->equals(true);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenComparingIntWithBooleanStrictly(): void
    {
        $validator = new Validator(['field' => 1]);
        $validator->field('field')->equals(true, true);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->equals('foo');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => 'foo']);
        $validator->field('field')->equals('bar');
        $validator->messages('field')->equals('Message equals');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message equals', $validator->errors()->first('field')?->getMessage());
    }
}
