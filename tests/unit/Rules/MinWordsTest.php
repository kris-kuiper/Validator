<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class MinWordsTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['word1 word2 word3 word4 word5', 'word1 word2 word3 word4', 'word1 word2 word3'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->minWords(3);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvidedUsingMinimumCharacters(): void
    {
        foreach (['word1 word2 word3 word4 word5', 'word1 word2 word3 word4', 'word1 word2 word3'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->minWords(3, 5);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvidedUsingAlphaNumeric(): void
    {
        foreach (['word# word$ word^ w%ord w@ord', 'wor@d wo1(rd wo%rd wo#rd52', 'wo5r@d wo!rd2 wor$%d'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->minWords(3, 4, false);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach (['word1', 'word3 word4', 'word# word$ word^ w%ord w@ord', 'wor@d wo1(rd wo%rd wo#rd52', 'wo5r@d wo!rd2 wor$%d', null, [], (object) [], ['a', 'b', 'c', 'd'], true] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->minWords(3);
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
            $validator->field('field')->minWords(2, 8);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->minWords(1);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->minWords(2);
        $validator->messages('field')->minWords('Message min words');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message min words', $validator->errors()->first('field')->getMessage());
    }
}
