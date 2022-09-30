<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class NegativeTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyIntValuesAreProvided(): void
    {
        foreach ([-1, -10, -0.1, '-1', '-10', '-0.1'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->negative();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonIntValuesAreProvided(): void
    {
        foreach ([(object) [], 'abcd123', ' ', true, false, '', 2.5, '1', 0.1, '0.1', 0, '0'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->negative();
            $this->assertFalse($validator->execute());
        }
    }


    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenIntValuesAreProvidedInStrictMode(): void
    {
        foreach (['-1', '-10', '-0.1'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->negative(true);
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
        $validator->field('field')->negative();
        $validator->messages('field')->negative('Message is negative');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is negative', $validator->errors()->first('field')?->getMessage());
    }
}
