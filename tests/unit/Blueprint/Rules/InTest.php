<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class InTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([1, '1', true, 0, '0', false] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->in([0, 1]);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInvalidValuesAreProvided(): void
    {
        foreach ([null, [], ['a', 'b', 'c', 'd'], 2552, '2817334'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->in(['foo']);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInvalidValuesAreProvidedInStrictMode(): void
    {
        foreach (['1', true, '0', false, '2'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->in([0, 1], true);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->in(['foo']);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->in([0, 1]);
        $validator->messages('field')->in('Message in');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message in', $validator->errors()->first('field')?->getMessage());
    }
}
