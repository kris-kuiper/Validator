<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class DifferentTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([['a', 'b', 'c'], [1, 2, 3], [1, 2, 3, 4, 5], ['foo' => 1, 'bar' => 2, 'quez' => 3], ] as $data) {
            $validator = new Validator(['field1' => $data, 'field2' => 'test']);
            $validator->field('field1')->different('field2');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvidedUsingMultipleFields(): void
    {
        foreach (['testing', '', 'tes', 'Test', 'TEST', ' test ', 0, null, true] as $data) {
            $validator = new Validator(['field1' => $data, 'field2' => $data, 'field3' => 'test']);
            $validator->field('field1')->different('field2', 'field3');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        $validator = new Validator(['field' => 'test', 'field2' => 'test']);
        $validator->field('field')->different('field2');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvidedUsingMultipleFields(): void
    {
        $validator = new Validator(['field1' => 'test', 'field2' => 'test', 'field3' => 'test']);
        $validator->field('field1')->different('field2', 'field3');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field1')->different('field2');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field1' => '', 'field2' => '']);
        $validator->field('field1')->different('field2');
        $validator->messages('field1')->different('Message different');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message different', $validator->errors()->first('field1')->getMessage());
    }
}
