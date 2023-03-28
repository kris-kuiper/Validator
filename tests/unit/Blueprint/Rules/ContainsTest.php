<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ContainsTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['test', 'testtest', ' test ', 'another test', 'foo test bar', 'footestbar', 'fooTESTbar', 'foo TEST bar', 'TeSt'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->contains('test');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], 2552, true, '2817334'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->contains('test');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->contains('test');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCaseSensitiveValuesAreProvided(): void
    {
        foreach (['test', 'testtest', ' test ', 'another test', 'foo test bar', 'footestbar'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->contains('test', true);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenCaseSensitiveValuesAreProvided(): void
    {
        foreach (['TEST', 'TESTTEST', ' Test ', 'TeST', 'foo tEst bar', 'footEstbar'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->contains('test', true);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->contains('test');
        $validator->messages('field')->contains('Message contains');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message contains', $validator->errors()->first('field')?->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator();
        $validator->field('field')->contains(1);
        $validator->messages('field')->contains('Message contains');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message contains', $validator->errors()->first('field')?->getMessage());
    }
}
