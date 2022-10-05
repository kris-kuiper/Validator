<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ContainsSymbolTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyBoolValuesAreProvided(): void
    {
        foreach (['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', "'", '"', ':', ';', '.', '/', '\\', '<', '>', '?', '`', '~', '[', ']', '{', '}', '-', 'abc # i'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsSymbol();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenProvidedTwoSymbols(): void
    {
        $validator = new Validator(['field' => 'p@assword!']);
        $validator->field('field')->containsSymbol(2);
        $validator->execute();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailWhenProvidingNotEnoughSymbols(): void
    {
        $validator = new Validator(['field' => 'p@assword!']);
        $validator->field('field')->containsSymbol(3);
        $validator->execute();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassWhenProvidingZeroSymbolsWhileRequestingZeroSymbols(): void
    {
        $validator = new Validator(['field' => 'password']);
        $validator->field('field')->containsSymbol(0);
        $validator->execute();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonBoolValuesAreProvided(): void
    {
        foreach ([null, (object) [], 2552, 1, 0, '2817334', 'abcd', '1238ab'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsSymbol();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->containsSymbol();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->containsSymbol();
        $validator->messages('field')->containsSymbol('Message symbols');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message symbols', $validator->errors()->first('field')?->getMessage());
    }
}
