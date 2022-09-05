<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class DigitsMaxTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, '12345', 12345, 123, '123', 1, '1', '-10', -10, -12345, '-12345', 12.345, 12.34, 12.3457] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->digitsMax(5);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([123456, '123456', 123456789, '123456789'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->digitsMax(5);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->digitsMax(5);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => 123456]);
        $validator->field('field')->digitsMax(5);
        $validator->messages('field')->digitsMax('Message max digits');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message max digits', $validator->errors()->first('field')?->getMessage());
    }
}
