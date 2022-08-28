<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class BeforeTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidDatesAreProvided(): void
    {
        foreach (['1987-11-09', '2000-01-01', '1500-01-01'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->before('2022-01-01');
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
            $validator->field('field')->before('2022-01-01');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoDatesAreProvided(): void
    {
        $validator = new Validator([]);
        $validator->field('field')->before('2022-01-01');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldReturnCorrectMessageWhenCustomMessageIsSet(): void
    {
        $validator = new Validator([]);
        $validator->field('field')->before('2022-01-01');
        $validator->messages('field')->before('Message before');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message before', $validator->errors()->first('field')->getMessage());
    }
}
