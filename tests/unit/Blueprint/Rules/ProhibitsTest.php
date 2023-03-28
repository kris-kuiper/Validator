<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ProhibitsTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldIsNotPresent(): void
    {
        $validator = new Validator(['field' => null]);
        $validator->field('field')->prohibits('field2');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldsAreNotPresent(): void
    {
        $validator = new Validator(['field' => null]);
        $validator->field('field')->prohibits('field2', 'field3');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldIsPresent(): void
    {
        $validator = new Validator(['field' => null, 'field2' => null]);
        $validator->field('field')->prohibits('field2');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldsArePresent(): void
    {
        $validator = new Validator(['field' => null, 'field2' => null, 'field3' => null]);
        $validator->field('field')->prohibits('field2', 'field3');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenSomeOtherFieldsArePresent(): void
    {
        $validator = new Validator(['field' => null, 'field2' => null]);
        $validator->field('field')->prohibits('field2', 'field3');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([(object) [], 2552, true, false, '2817334', -25, 5.52, ' ', '20,20'] as $data) {
            $validator = new Validator(['field1' => $data]);
            $validator->field('field1')->prohibits('field2');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInvalidValuesAreProvided(): void
    {
        foreach ([(object) [], 2552, true, false, '2817334', -25, 5.52, ' ', '20,20'] as $data) {
            $validator = new Validator(['field1' => $data, 'field2' => $data]);
            $validator->field('field1')->prohibits('field2');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoFieldsAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->prohibits();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field1' => null, 'field2' => null]);
        $validator->field('field1')->prohibits('field2');
        $validator->messages('field1')->prohibits('Message prohibits');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message prohibits', $validator->errors()->first('field1')?->getMessage());
    }
}
