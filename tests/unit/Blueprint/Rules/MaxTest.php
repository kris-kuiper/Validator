<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class MaxTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['1', '2', '3', '4', '5', '-10', 1, 2, 3, 4, 5, -10, (object) [], [], 'abcdef', true] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->max(5);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([6, '6'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->max(5);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->max(5);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => 8]);
        $validator->field('field')->max(5);
        $validator->messages('field')->max('Message max');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message max', $validator->errors()->first('field')->getMessage());
    }
}
