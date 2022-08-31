<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class MinTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['5', 5, '5.5', 5.5, '6', 6] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->min(5);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach (['1', '2', '3', 1, 2, 3, -10, '-10', 0, '0', (object) [], [], 'abcdef', true, false, 2.52, '2.52'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->min(5);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->min(5);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => 2]);
        $validator->field('field')->min(5);
        $validator->messages('field')->min('Message min');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message min', $validator->errors()->first('field')->getMessage());
    }
}
