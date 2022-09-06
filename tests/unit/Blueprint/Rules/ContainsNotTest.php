<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ContainsNotTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], 2552, true, '2817334'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsNot('test');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach (['test', 'testtest', ' test ', 'another test', 'foo test bar', 'footestbar', 'fooTESTbar', 'foo TEST bar', 'TeSt'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsNot('test');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->containsNot('test');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCaseSensitiveValuesAreProvided(): void
    {
        foreach (['TEST', 'TESTTEST', ' Test ', 'TeST', 'foo tEst bar', 'footEstbar'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsNot('test', true);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenCaseSensitiveValuesAreProvided(): void
    {
        foreach (['test', 'testtest', ' test ', 'another test', 'foo test bar', 'footestbar'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsNot('test', true);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => 'test']);
        $validator->field('field')->containsNot('test');
        $validator->messages('field')->containsNot('Message not contains');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message not contains', $validator->errors()->first('field')?->getMessage());
    }
}
