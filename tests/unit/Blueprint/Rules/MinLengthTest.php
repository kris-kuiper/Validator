<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class MinLengthTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['abcdef', '123456', 12345] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->minLength(5);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], true, '1', '12', '123', '1234', 1, 12, 123, 1234, false] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->minLength(5);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->minLength(5);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->minLength(5);
        $validator->messages('field')->minLength('Message min length');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message min length', $validator->errors()->first('field')?->getMessage());
    }
}
