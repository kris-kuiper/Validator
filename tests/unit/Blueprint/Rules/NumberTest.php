<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class NumberTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyNumberValuesAreProvided(): void
    {
        foreach (['12345', 12345, '5.52', 5.52, -5.52, '-5.52', 5.2829453113567E+269] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->number();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyNumberValuesAreProvidedWhenUsingStrictMode(): void
    {
        foreach ([12345, 5.52, -5.52, 5.2829453113567E+269] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->number(true);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonNumberValuesAreProvided(): void
    {
        foreach (['a', null, (object) [], [], 'abcdef', true, false, '5.2.5'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->number();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonNumberValuesAreProvidedWhenUsingStrictMode(): void
    {
        foreach (['12345', '5.52', '-5.52'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->number(true);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => ' ']);
        $validator->field('field')->number();
        $validator->messages('field')->number('Message is number');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is number', $validator->errors()->first('field')?->getMessage());
    }
}
