<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class AfterOrEqualTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidDatesAreProvided(): void
    {
        foreach ([date('Y-m-d'), '1987-11-09', '3000-01-01', '1952-03-28'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->afterOrEqual('1952-03-28');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidDatesAndDateFormatAreProvided(): void
    {
        foreach ([date('d-m-Y'), '09-11-1987', '01-01-3000', '28-03-1952'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->afterOrEqual('28-03-1952', 'd-m-Y');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidDatesAreProvided(): void
    {
        foreach (['', null, [], (object) [], 2552, true, '1952-03-27', '900-01-01'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->afterOrEqual('1952-03-28');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidDatesAndDateFormatAreProvided(): void
    {
        foreach (['', null, [], (object) [], 2552, true, '27-03-1952', '01-01-900', '2000-01-01'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->afterOrEqual('28-03-1952', 'd-m-Y');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoDatesAreProvided(): void
    {
        $validator = new Validator([]);
        $validator->field('field')->afterOrEqual('1952-03-28');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator([]);
        $validator->field('field')->afterOrEqual('1952-03-28');
        $validator->messages('field')->afterOrEqual('Message after or equal');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message after or equal', $validator->errors()->first('field')?->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfExceptionIsThrownWhenWrongDateFormatIsProvided(): void
    {
        $this->expectException(ValidatorException::class);

        $validator = new Validator([]);
        $validator->field('field')->afterOrEqual('1952-03-28', 'foo');
        $validator->execute();
    }
}
