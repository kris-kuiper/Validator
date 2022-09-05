<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class WordsTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['word1 word2 word3', 'word word word'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->words(3);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvidedUsingMinimumCharacters(): void
    {
        foreach (['word1 word2 word3', 'word word word'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->words(3, 4);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvidedUsingAlphaNumeric(): void
    {
        foreach (['word1 word2 word3', 'word word word', 'w@o2rd w$ord w*^ord2'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->words(3, 4, false);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach (['word1 word2', 'word1', null, [], (object) [], ['a', 'b', 'c'], true] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->words(3);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvidedUsingMinimumCharacters(): void
    {
        foreach (['word1 word2 word3 word4 word5', 'word1 word2 word3 word4', 'word1 word2 word3', 'word1 word2'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->words(3, 6);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvidedUsingAlphaNumeric(): void
    {
        foreach (['word1^ word2 word3 word4 word5', 'word1 word2% word3 word4%', 'word1 word2@'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->words(3, 2, false);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->words(3);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => 'word word word']);
        $validator->field('field')->words(2);
        $validator->messages('field')->words('Message words');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message words', $validator->errors()->first('field')?->getMessage());
    }
}
