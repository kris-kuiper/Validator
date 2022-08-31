<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class MaxLengthTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], true, '1', '12', '123', '1234', '12345', 1, 12, 123, 1234, 12345] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->maxLength(5);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach (['abcdef', '123456'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->maxLength(5);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->maxLength(5);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => 123456]);
        $validator->field('field')->maxLength(5);
        $validator->messages('field')->maxLength('Message max length');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message max length', $validator->errors()->first('field')->getMessage());
    }
}
