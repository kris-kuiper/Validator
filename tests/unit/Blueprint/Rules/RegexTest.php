<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class RegexTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['1', '2', 1, 2, 'abc123'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->regex('/^[a-zA-Z0-9]+$/');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([(object) [], [], -10, false, true, '-10'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->regex('/^[a-zA-Z0-9]+$/');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->regex('/^[a-zA-Z0-9]+$/');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->regex('/^[a-zA-Z0-9]+$/');
        $validator->messages('field')->regex('Message regex');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message regex', $validator->errors()->first('field')?->getMessage());
    }
}
