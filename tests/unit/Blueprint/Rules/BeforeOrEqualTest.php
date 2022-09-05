<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class BeforeOrEqualTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidDatesAreProvided(): void
    {
        foreach (['1987-11-09', '2000-01-01', '1500-01-01', '2022-01-01'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->beforeOrEqual('2022-01-01');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidDatesAndCustomFormatAreProvided(): void
    {
        foreach (['09-11-1987', '01-01-2000', '01-01-1500', '01-01-2022'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->beforeOrEqual('01-01-2022', 'd-m-Y');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidDatesAreProvided(): void
    {
        foreach (['', null, [], (object) [], 2552, true, date('Y-m-d'), '3000-01-01'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->beforeOrEqual('2022-01-01');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidDatesAndCustomFormatAreProvided(): void
    {
        foreach (['', null, [], (object) [], 2552, true, date('Y-m-d'), '01-01-3000', '25-05-2025'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->beforeOrEqual('01-01-2022', 'd-m-Y');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoDatesAreProvided(): void
    {
        $validator = new Validator([]);
        $validator->field('field')->beforeOrEqual('2022-01-01');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldReturnCorrectMessageWhenCustomMessageIsSet(): void
    {
        $validator = new Validator([]);
        $validator->field('field')->beforeOrEqual('2022-01-01');
        $validator->messages('field')->beforeOrEqual('Message before or equal');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message before or equal', $validator->errors()->first('field')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldThrowExceptionWhenWrongDateFormatIsProvided(): void
    {
        $this->expectException(ValidatorException::class);

        $validator = new Validator([]);
        $validator->field('field')->beforeOrEqual('2022-01-01', 'foo');
        $validator->execute();
    }
}
