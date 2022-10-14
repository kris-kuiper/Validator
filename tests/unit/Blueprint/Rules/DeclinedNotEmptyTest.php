<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class DeclinedNotEmptyTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([0, '0', 'false', false, 'no', 'off'] as $data) {
            $validator = new Validator(['foo' => $data, 'bar' => 'yes']);
            $validator->field('foo')->declinedNotEmpty('bar');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherDeclinedValuesAreProvided(): void
    {
        $validator = new Validator(['foo' => 'bar', 'bar' => 'foo']);
        $validator->field('foo')->declinedNotEmpty('bar', ['foo', 'bar', 'quez']);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherDeclinedValuesAreProvided(): void
    {
        $validator = new Validator(['foo' => '2', 'bar' => 'foo']);
        $validator->field('foo')->declinedNotEmpty('bar', [2, 'bar', 'quez']);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], ['a', 'b', 'c'], 2552, true, '2817334', 'yes', '1', 1, 'on', 'true'] as $data) {
            $validator = new Validator(['foo' => $data, 'bar' => 'yes']);
            $validator->field('foo')->declinedNotEmpty('bar');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvidedAndOtherFieldIsNotProvided(): void
    {
        foreach ([null, [], (object) [], ['a', 'b', 'c'], 2552, true, '2817334', 'yes', '1', 1, 'on', 'true'] as $data) {
            $validator = new Validator(['foo' => $data, 'bar' => '']);
            $validator->field('foo')->declinedNotEmpty('bar');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->declinedNotEmpty('bar');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['foo' => '']);
        $validator->field('foo')->declinedNotEmpty('bar');
        $validator->messages('foo')->declinedNotEmpty('Message declined not empty');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message declined not empty', $validator->errors()->first('foo')->getMessage());
    }
}
