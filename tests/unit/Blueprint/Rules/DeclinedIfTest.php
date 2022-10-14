<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class DeclinedIfTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([0, '0', 'false', false, 'no', 'off'] as $data) {
            $validator = new Validator(['field' => $data, 'foo' => 'bar']);
            $validator->field('field')->declinedIf('foo', 'bar');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenDeclinedIsNotRequired(): void
    {
        foreach ([1, '1', 'true', true, 'yes', 'on'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->declinedIf('foo', 'bar');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherDeclinedValuesAreProvided(): void
    {
        foreach (['foo', 'bar', 2, '22.5'] as $data) {
            $validator = new Validator(['field' => $data, 'foo' => 'bar']);
            $validator->field('field')->declinedIf('foo', 'bar', ['foo', 'bar', 2, '22.5']);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherDeclinedValuesAreProvided(): void
    {
        $validator = new Validator(['field' => '2', 'foo' => 'bar']);
        $validator->field('field')->declinedIf('foo', 'bar', [2, 'bar', 'quez']);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], ['a', 'b', 'c'], 2552, true, '2817334', 'yes', '1', 1, 'on', 'true'] as $data) {
            $validator = new Validator(['field' => $data, 'foo' => 'bar']);
            $validator->field('field')->declinedIf('foo', 'bar');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator(['foo' => 'bar']);
        $validator->field('field')->declinedIf('foo', 'bar');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '', 'foo' => 'bar']);
        $validator->field('field')->declinedIf('foo', 'bar');
        $validator->messages('field')->declinedIf('Message declined if');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message declined if', $validator->errors()->first('field')?->getMessage());
    }
}
