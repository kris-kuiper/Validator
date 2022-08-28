<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class DifferentWithAllTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['testing', '', 'tes', 'Test', 'TEST', ' test ', 0, null, true] as $data) {
            $validator = new Validator(['field1' => $data, 'field2' => 'test']);
            $validator->field('field1')->differentWithAll('field2');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvidedUsingMultipleFields(): void
    {
        foreach (['testing', '', 'tes', 'Test', 'TEST', ' test ', 0, null, true] as $data) {
            $validator = new Validator(['field1' => $data, 'field2' => 'test', 'field3' => 'test']);
            $validator->field('field1')->differentWithAll('field2', 'field3');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach (['testing', '', 'tes', 'Test', 'TEST', ' test ', 0, null, true] as $data) {
            $validator = new Validator(['field1' => $data, 'field2' => $data, 'field3' => 'test']);
            $validator->field('field1')->differentWithAll('field2', 'field3');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvidedUsingMultipleFields(): void
    {
        $validator = new Validator(['field1' => 'test', 'field2' => 'test1', 'field3' => 'test']);
        $validator->field('field1')->differentWithAll('field2', 'field3');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field1')->differentWithAll('field2');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field1' => '', 'field2' => '']);
        $validator->field('field1')->differentWithAll('field2');
        $validator->messages('field1')->differentWithAll('Message different with all');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message different with all', $validator->errors()->first('field1')->getMessage());
    }
}
