<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class EndsNotWithTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach (['test' => 'test', 'this is a test' => 'test', 'tEst' => 'Test', 1 => 1, 11 => 1, '2' => 2, '22' => '22', '5.5' => '5.5'] as $value => $expects) {
            $validator = new Validator(['field' => $value]);
            $validator->field('field')->endsNotWith($expects);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvidedWithCaseSensitive(): void
    {
        foreach (['test' => 'test', 'this is a test' => 'test', 'TEST' => 'TEST', 'this is a TEST' => 'TEST', 1 => 1, 11 => 1, '2' => 2, '22' => '22', '5.5' => '5.5'] as $value => $expects) {
            $validator = new Validator(['field' => $value]);
            $validator->field('field')->endsNotWith($expects, true);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], 2552, true, '2817334', [1, 2], ['a', 'b'], ['foo' => 'bar'], 'test ', 5.5] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->endsNotWith('test');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvidedCaseSensitive(): void
    {
        foreach (['test' => 'Test', 'this is a Test' => 'test', 'teSt' => 'test'] as $value => $expects) {
            $validator = new Validator(['field' => $value]);
            $validator->field('field')->endsNotWith($expects, true);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->endsNotWith('test');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => 'test']);
        $validator->field('field')->endsNotWith('test');
        $validator->messages('field')->endsNotWith('Message ends not with');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message ends not with', $validator->errors()->first('field')->getMessage());
    }
}
