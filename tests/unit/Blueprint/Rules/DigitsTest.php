<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class DigitsTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['12345', 12345] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->digits(5);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, 123456, 1234, '123456', '1234', 12.345, 12.34, 12.3457] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->digits(5);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->digits(5);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->digits(5);
        $validator->messages('field')->digits('Message digits');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message digits', $validator->errors()->first('field')?->getMessage());
    }
}
