<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsNotNullTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNonNullValueIsProvided(): void
    {
        foreach ([[], (object) [], true, false, 0, 123, 52.25, -24, 'foo', '123.5'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isNotNull();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingWildcards(): void
    {
        $validator = new Validator(['field' => [null, null, null]]);
        $validator->field('field.*')->isNotNull();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValueIsProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->isNotNull();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => null]);
        $validator->field('field')->isNotNull();
        $validator->messages('field')->isNotNull('Message is not null');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is not null', $validator->errors()->first('field')?->getMessage());
    }
}
