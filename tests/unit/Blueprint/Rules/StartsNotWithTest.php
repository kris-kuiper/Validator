<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class StartsNotWithTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach (['test' => 'test', 'testing' => 'test', 'test is all you need' => 'test', 'tEst' => 'Test', 1 => 1, 11 => 1, '2' => 2, '22' => '22', '5.5' => '5.5'] as $value => $expects) {
            $validator = new Validator(['field' => $value]);
            $validator->field('field')->startsNotWith($expects);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvidedWithCaseSensitive(): void
    {
        foreach (['test' => 'test', 'test is all you need' => 'test', 'testing' => 'test', 'TEST' => 'TEST', 'TEST is all you need' => 'TEST', 1 => 1, 11 => 1, '2' => 2, '22' => '22', '5.5' => '5.5'] as $value => $expects) {
            $validator = new Validator(['field' => $value]);
            $validator->field('field')->startsNotWith($expects, true);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], 2552, true, '2817334', [1, 2], ['a', 'b'], ['foo' => 'bar'], ' test', 5.5] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->startsNotWith('test');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvidedCaseSensitive(): void
    {
        foreach (['test' => 'Test', 'Test is all you need' => 'test', 'teSt' => 'test'] as $value => $expects) {
            $validator = new Validator(['field' => $value]);
            $validator->field('field')->startsNotWith($expects, true);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->startsNotWith('test');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => 'test']);
        $validator->field('field')->startsNotWith('test');
        $validator->messages('field')->startsNotWith('Message starts not with');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message starts not with', $validator->errors()->first('field')->getMessage());
    }
}
