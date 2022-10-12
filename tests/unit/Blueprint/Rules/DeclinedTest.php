<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class DeclinedTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([0, '0', 'false', false, 'no', 'off'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->declined();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherDeclinedValuesAreProvided(): void
    {
        foreach (['foo', 'bar', 2, '22.5'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->declined(['foo', 'bar', 2, '22.5']);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherDeclinedValuesAreProvided(): void
    {
        $validator = new Validator(['foo' => '2']);
        $validator->field('foo')->declined([2, 'bar', 'quez']);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], ['a', 'b', 'c'], 2552, true, '2817334', 'yes', '1', 1, 'on'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->declined();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->declined();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->declined();
        $validator->messages('field')->declined('Message declined');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message declined', $validator->errors()->first('field')?->getMessage());
    }
}
