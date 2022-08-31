<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsStringTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenStringValuesAreProvided(): void
    {
        foreach (['a', 'foo bar', "foo bar", '1234', '-1234'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isString();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonStringValuesAreProvided(): void
    {
        foreach ([[], (object) [], null, true, false, 0, 123, 52.25, -24] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isString();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => []]);
        $validator->field('field')->isString();
        $validator->messages('field')->isString('Message is string');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is string', $validator->errors()->first('field')?->getMessage());
    }
}
