<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class DigitsMinTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([123456, '123456', -12345, '-12345', '12345', 12345, 123456789, '123456789'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->digitsMin(5);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, 123, '123', 1, '1', '-10', -10, 12.345, 12.34, 12.3457] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->digitsMin(5);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->digitsMin(5);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator();
        $validator->field('field')->digitsMin(5);
        $validator->messages('field')->digitsMin('Message min digits');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message min digits', $validator->errors()->first('field')?->getMessage());
    }
}
