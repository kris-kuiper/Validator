<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class AcceptedNotEmptyTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([1, '1', 'true', true, 'yes', 'on'] as $data) {
            $validator = new Validator(['foo' => $data, 'bar' => 'yes']);
            $validator->field('foo')->acceptedNotEmpty('bar');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherAcceptedValuesAreProvided(): void
    {
        $validator = new Validator(['foo' => 'bar', 'bar' => 'foo']);
        $validator->field('foo')->acceptedNotEmpty('bar', ['foo', 'bar', 'quez']);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherAcceptedValuesAreProvided(): void
    {
        $validator = new Validator(['foo' => '2', 'bar' => 'foo']);
        $validator->field('foo')->acceptedNotEmpty('bar', [2, 'bar', 'quez']);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], ['a', 'b', 'c'], 2552, false, '2817334', 'no', '0', 0] as $data) {
            $validator = new Validator(['foo' => $data, 'bar' => 'yes']);
            $validator->field('foo')->acceptedNotEmpty('bar');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvidedAndOtherFieldIsNotProvided(): void
    {
        foreach ([null, [], (object) [], ['a', 'b', 'c'], 2552, false, '2817334', 'no', '0', 0] as $data) {
            $validator = new Validator(['foo' => $data, 'bar' => '']);
            $validator->field('foo')->acceptedNotEmpty('bar');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->acceptedNotEmpty('bar');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['foo' => '']);
        $validator->field('foo')->acceptedNotEmpty('bar');
        $validator->messages('foo')->acceptedNotEmpty('Message accepted not empty');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message accepted not empty', $validator->errors()->first('foo')->getMessage());
    }
}
