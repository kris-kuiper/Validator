<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsNullTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNullValueIsProvided(): void
    {
        $validator = new Validator(['field' => null]);
        $validator->field('field')->isNull();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingWildcards(): void
    {
        $validator = new Validator(['field' => [null, null, null]]);
        $validator->field('field.*')->isNull();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValueIsProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->isNull();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonNullValuesAreProvided(): void
    {
        foreach ([[], (object) [], true, false, 0, 123, 52.25, -24, 'foo', '123.5'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isNull();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => []]);
        $validator->field('field')->isNull();
        $validator->messages('field')->isNull('Message is null');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is null', $validator->errors()->first('field')?->getMessage());
    }
}
