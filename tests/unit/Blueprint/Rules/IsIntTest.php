<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsIntTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyIntValuesAreProvided(): void
    {
        foreach ([1, 2, 10, 100000, -1, -2, -10, -1000000, 0, '1', '2', '10', '100000', '-1', '-2', '-10', '-1000000', '0'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isInt();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonIntValuesAreProvided(): void
    {
        foreach ([(object) [], 'abcd123', ' ', true, false, '', 2.5, -2.5] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isInt();
            $this->assertFalse($validator->execute());
        }
    }


    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenIntValuesAreProvidedInStrictMode(): void
    {
        foreach (['1', '2', '10', '100000', '-1', '-2', '-10', '-1000000', '0'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isInt(true);
            $validator->execute();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => ' ']);
        $validator->field('field')->isInt();
        $validator->messages('field')->isInt('Message is int');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is int', $validator->errors()->first('field')?->getMessage());
    }
}
