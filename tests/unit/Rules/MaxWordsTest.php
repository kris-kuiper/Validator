<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class MaxWordsTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['word1 word2 word3', 'word1 word2', 'word1', null, [], (object) [], ['a', 'b', 'c'], true] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->maxWords(3);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvidedUsingMinimumCharacters(): void
    {
        foreach (['word1 word2 word3', 'word1 word2', 'word1'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->maxWords(3, 5);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvidedUsingAlphaNumeric(): void
    {
        foreach (['word^ word@ word', 'word% word', 'word%'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->maxWords(3, 4, false);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach (['word1 word2 word3 word4 word5', 'word1 word2 word3 word4', 'word1 word2 word3'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->maxWords(2);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvidedUsingMinimumCharacters(): void
    {
        foreach (['word1 word2 word3 word4 word5', 'word1 word2 word3 word4', 'word1 word2 word3'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->maxWords(2, 3);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvidedUsingAlphaNumeric(): void
    {
        foreach (['word1^ word2 word3 word4 word5', 'word1 word2% word3 word4%', 'word1 word2@ word3'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->maxWords(2, 2, false);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->maxWords(5);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => 'word word word']);
        $validator->field('field')->maxWords(2);
        $validator->messages('field')->maxWords('Message max words');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message max words', $validator->errors()->first('field')->getMessage());
    }
}
