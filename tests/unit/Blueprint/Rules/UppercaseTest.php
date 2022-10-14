<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class UppercaseTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenStringValuesAreProvided(): void
    {
        foreach (['A', 'FOO BAR', 'FOO 1234', '1234', ''] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->uppercase();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonStringValuesAreProvided(): void
    {
        foreach ([[], (object) [], null, true, false, 0, 123, 52.25, -24, 'foo', 'Foo', 'FOO BAr', 'FOO 25 bar', 'foo 25'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->uppercase();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => null]);
        $validator->field('field')->uppercase();
        $validator->messages('field')->uppercase('Message is uppercase');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is uppercase', $validator->errors()->first('field')?->getMessage());
    }
}
