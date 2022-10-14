<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ContainsMixedCaseTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyBoolValuesAreProvided(): void
    {
        foreach (['aB', 'Ab', 'This is a test', '1000AA - foo'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsMixedCase();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCorrectAmountOfMixedCaseAreProvided(): void
    {
        foreach (['abcBCD', 'Ab12CdEf', 'This is A tesT', '1000AA - Foo bar'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsMixedCase(3, 3);
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenIncorrectAmountOfMixedCaseAreProvided(): void
    {
        foreach (['acBCD', 'abcBC', 'A12CdEf', 'Ab12dEf', '1000AA - Foo', 'ab'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsMixedCase(3, 3);
            $validator->execute();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonBoolValuesAreProvided(): void
    {
        foreach ([null, (object) [], 2552, 1, 0, '2817334', 'abcd', '1238ab', 'ABCD'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsMixedCase();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->containsMixedCase();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->containsMixedCase();
        $validator->messages('field')->containsMixedCase('Message mixedCase');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message mixedCase', $validator->errors()->first('field')?->getMessage());
    }
}
