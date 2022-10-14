<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class AcceptedTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([1, '1', 'true', true, 'yes', 'on'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->accepted();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherAcceptedValuesAreProvided(): void
    {
        foreach (['foo', 'bar', 2, '22.5'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->accepted(['foo', 'bar', 2, '22.5']);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherAcceptedValuesAreProvided(): void
    {
        $validator = new Validator(['foo' => '2']);
        $validator->field('foo')->accepted([2, 'bar', 'quez']);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], ['a', 'b', 'c'], 2552, false, '2817334', 'no', '0', 0, 'off'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->accepted();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->accepted();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->accepted();
        $validator->messages('field')->accepted('Message accepted');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message accepted', $validator->errors()->first('field')?->getMessage());
    }
}
