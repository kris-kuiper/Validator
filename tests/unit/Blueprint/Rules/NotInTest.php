<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class NotInTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenValidValuesAreProvided(): void
    {
        foreach ([0, '0', false, [], (object) [], 2.5] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->notIn(['1', 'b']);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenValidValuesAreProvidedInStrictMode(): void
    {
        foreach ([1, 0] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->notIn(['0', '1'], true);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldFailValidationWhenInvalidValuesAreProvided(): void
    {
        foreach (['foo', 'bar', '1', 1, true] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->notIn(['foo', 'bar', '1', 1]);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldFailValidationWhenInvalidValuesAreProvidedInStrictMode(): void
    {
        foreach ([1, 0] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->notIn([0, 1], true);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldFailValidationWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->notIn(['foo']);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => 0]);
        $validator->field('field')->notIn([0, 1]);
        $validator->messages('field')->notIn('Message not in');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message not in', $validator->errors()->first('field')?->getMessage());
    }
}
