<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class PositiveOrZeroTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyIntValuesAreProvided(): void
    {
        foreach ([0, 1, 10, 0.1, '0', '1', '10', '0.1'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->positiveOrZero();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonIntValuesAreProvided(): void
    {
        foreach ([(object) [], 'abcd123', ' ', true, false, '', -2.5, '-1', -0.1, '-0.1'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->positiveOrZero();
            $this->assertFalse($validator->execute());
        }
    }


    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenIntValuesAreProvidedInStrictMode(): void
    {
        foreach (['0', '1', '10', '0.1'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->positiveOrZero(true);
            $validator->execute();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->positiveOrZero();
        $validator->messages('field')->positiveOrZero('Message is positive or zero');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is positive or zero', $validator->errors()->first('field')?->getMessage());
    }
}
