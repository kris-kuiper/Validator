<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ContainsLetterTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyBoolValuesAreProvided(): void
    {
        foreach (['a', 'abc', '0a1', 'A', 'ABC', 'AbC', 'This is a test', '52 x 52'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsLetter();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCorrectAmountOfLettersAreProvided(): void
    {
        foreach (['ab', 'abc', 'a b', 'A b', 'A B', 'ABC', 'AbC', 'This is a test', 'a 52 x 52'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsLetter(2);
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenIncorrectAmountOfLettersAreProvided(): void
    {
        foreach (['ab', 'abc', 'a b', 'A b', 'A B', 'ABC', 'AbC', 'a 52 x 52'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsLetter(5);
            $validator->execute();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonBoolValuesAreProvided(): void
    {
        foreach ([null, (object) [], 2552, 1, 0, '2817334'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsLetter();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->containsLetter();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->containsLetter();
        $validator->messages('field')->containsLetter('Message letters');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message letters', $validator->errors()->first('field')?->getMessage());
    }
}
