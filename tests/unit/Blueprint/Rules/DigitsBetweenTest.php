<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class DigitsBetweenTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['12345', 12345, '1234', '1234', '123456', 123456, -12345, -1234, -123456, '-1234', '-12345'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->digitsBetween(4, 6);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, 1234567, 123, '1234567', '123', 12.34, '12.34'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->digitsBetween(4, 6);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->digitsBetween(4, 6);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->digitsBetween(4, 6);
        $validator->messages('field')->digitsBetween('Message digits between');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message digits between', $validator->errors()->first('field')?->getMessage());
    }
}
