<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ContainsDigitTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyBoolValuesAreProvided(): void
    {
        foreach (['a1', '1', '1a', 1, 'This is a 8 test', 'Foo 5.2', 5.2, -5.2, -3, 3] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsDigit();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCorrectAmountOfNumbersAreProvided(): void
    {
        foreach (['12a3', 123, 1234, 12.34, '12.34', '-5.22', -5.22, '1 2 3', 'This 1 is 2 a 3 test'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsDigit(3);
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenIncorrectAmountOfNumbersAreProvided(): void
    {
        foreach (['12a3', 123, 1234, 12.34, '12.34', '-5.22', -5.22, '1 2 3', 'This 1 is 2 a 3 test'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsDigit(5);
            $validator->execute();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonBoolValuesAreProvided(): void
    {
        foreach ([null, (object) [], true, false, 'abcd', 'ABCD'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsDigit();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->containsDigit();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->containsDigit();
        $validator->messages('field')->containsDigit('Message digit');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message digit', $validator->errors()->first('field')?->getMessage());
    }
}
