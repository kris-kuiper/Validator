<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class AfterTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidDatesAreProvided(): void
    {
        foreach ([date('Y-m-d'), '1987-11-09', '3000-01-01'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->after('1952-03-28');
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
            $validator->field('field')->after('1952-03-28');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoDatesAreProvided(): void
    {
        $validator = new Validator([]);
        $validator->field('field')->after('1952-03-28');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldReturnCorrectMessageWhenCustomMessageIsSet(): void
    {
        $validator = new Validator([]);
        $validator->field('field')->after('1952-03-28');
        $validator->messages('field')->after('Message after');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message after', $validator->errors()->first('field')->getMessage());
    }
}
