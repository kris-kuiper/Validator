<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class EndsWithTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['test' => 'test', 'this is a test' => 'test', 'tEst' => 'Test', 1 => 1, 11 => 1, '2' => 2, '22' => '22', '5.5' => '5.5'] as $value => $expects) {
            $validator = new Validator(['field' => $value]);
            $validator->field('field')->endsWith($expects);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvidedWithCaseSensitive(): void
    {
        foreach (['test' => 'test', 'this is a test' => 'test', 'TEST' => 'TEST', 'this is a TEST' => 'TEST', 1 => 1, 11 => 1, '2' => 2, '22' => '22', '5.5' => '5.5'] as $value => $expects) {
            $validator = new Validator(['field' => $value]);
            $validator->field('field')->endsWith($expects, true);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], 2552, true, '2817334', [1, 2], ['a', 'b'], ['foo' => 'bar'], 'test ', 5.5] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->endsWith('test');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvidedCaseSensitive(): void
    {
        foreach (['test' => 'Test', 'this is a Test' => 'test', 'teSt' => 'test'] as $value => $expects) {
            $validator = new Validator(['field' => $value]);
            $validator->field('field')->endsWith($expects, true);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->endsWith('test');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->endsWith('test');
        $validator->messages('field')->endsWith('Message ends with');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message ends with', $validator->errors()->first('field')?->getMessage());
    }
}
