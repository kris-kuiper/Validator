<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsDateTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['2000-01-01', '1952-03-28', '1900-01-01', '2200-01-01', '2024-02-29'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isDate();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], ['a', 'b', 'c'], 2552, false, '2817334', 'no', '0', 0, true, '2000-01-32', '2023-02-29'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isDate();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingDifferentDateFormat(): void
    {
        foreach (['01-01-2000', '28-03-1952', '01-01-1900', '01-01-2200', '29-02-2024'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isDate('d-m-Y');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->isDate();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->isDate();
        $validator->messages('field')->isDate('Message is date');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is date', $validator->errors()->first('field')->getMessage());
    }
}
