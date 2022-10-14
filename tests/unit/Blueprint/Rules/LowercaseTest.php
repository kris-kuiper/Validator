<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class LowercaseTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenStringValuesAreProvided(): void
    {
        foreach (['a', 'foo bar', 'foo 1234', '1234', ''] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->lowercase();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonStringValuesAreProvided(): void
    {
        foreach ([[], (object) [], null, true, false, 0, 123, 52.25, -24, 'FOO', 'fOO', 'FOO BAr', 'foo 25 BAR', 'FOO 25'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->lowercase();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => null]);
        $validator->field('field')->lowercase();
        $validator->messages('field')->lowercase('Message is lowercase');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is lowercase', $validator->errors()->first('field')?->getMessage());
    }
}
