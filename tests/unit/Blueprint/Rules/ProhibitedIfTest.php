<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ProhibitedIfTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach([null, '', []] as $data) {

            $validator = new Validator(['field1' => $data, 'field2' => 'foo']);
            $validator->field('field1')->prohibitedIf('field2');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingMultipleOtherFields(): void
    {
        foreach([null, '', []] as $data) {

            $validator = new Validator(['field1' => $data, 'field2' => 'foo', 'field3' => 'foo']);
            $validator->field('field1')->prohibitedIf('field2', 'field3');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach([(object) [], 2552, true, false, '2817334', -25, 5.52, ' ', '20,20'] as $data) {

            $validator = new Validator(['field1' => $data, 'field2' => 'foo']);
            $validator->field('field1')->prohibitedIf('field2');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingMultipleOtherFieldsAndOneOtherFieldIsEmpty(): void
    {
        $validator = new Validator(['field1' => 'foo', 'field2' => 'foo', 'field3' => null]);
        $validator->field('field1')->prohibitedIf('field2', 'field3', 'field4');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenUsingMultipleOtherFieldsAndAllOtherFieldsAreNotEmpty(): void
    {
        $validator = new Validator(['field1' => 'foo', 'field2' => 'foo', 'field3' => 'foo']);
        $validator->field('field1')->prohibitedIf('field2', 'field3');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldIsNotProvided(): void
    {
        foreach([(object) [], 2552, true, false, '2817334', -25, 5.52, ' ', '20,20'] as $data) {

            $validator = new Validator(['field1' => $data]);
            $validator->field('field1')->prohibitedIf('field2');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator(['field2' => 'foo']);
        $validator->field('field1')->prohibitedIf('field2');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field1' => 'foo', 'field2' => 'bar']);
        $validator->field('field1')->prohibitedIf('field2');
        $validator->messages('field1')->prohibitedIf('Message prohibited if');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message prohibited if', $validator->errors()->first('field1')?->getMessage());
    }
}
