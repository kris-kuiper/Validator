<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class DivisibleByTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyValidValuesAreProvided(): void
    {
        foreach ([100, 50, 10, '100', '50', '10'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->divisibleBy(10);
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonValidValuesAreProvided(): void
    {
        foreach ([(object) [], 'abcd123', ' ', true, false, '', 2.5, '1', 0.1, '0.1', 0] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->divisibleBy(10);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenZeroIsProvided(): void
    {
        $validator = new Validator(['field' => 10]);
        $validator->field('field')->divisibleBy(0);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenIntValuesAreProvidedInStrictMode(): void
    {
        foreach (['0', '-1', '-10', '-0.1'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->divisibleBy(10, true);
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
        $validator->field('field')->divisibleBy(10);
        $validator->messages('field')->divisibleBy('Message is negative or zero');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is negative or zero', $validator->errors()->first('field')?->getMessage());
    }
}
