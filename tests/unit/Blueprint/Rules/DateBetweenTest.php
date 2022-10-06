<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class DateBetweenTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        $validator = new Validator(['field' => '2000-01-01']);
        $validator->field('field')->dateBetween('1999-12-31', '2000-01-02');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], ['a', 'b', 'c'], 2552, false, '2817334', 'no', '0', 0, true, '2000-01-32', '2023-02-29', '2000-01-02', '1999-12-31'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->dateBetween('1999-12-31', '2000-01-02');
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingDifferentDateFormat(): void
    {
        $validator = new Validator(['field' => '01-01-2000']);
        $validator->field('field')->dateBetween('31-12-1999', '02-01-2000', 'd-m-Y');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->dateBetween('1999-12-31', '2000-01-02');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInvalidFromDateIsProvided(): void
    {
        $this->expectException(ValidatorException::class);

        $validator = new Validator();
        $validator->field('field')->dateBetween('1999-12-40', '2000-01-02');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfExceptionIsThrownWhenInvalidToDateIsProvided(): void
    {
        $this->expectException(ValidatorException::class);

        $validator = new Validator();
        $validator->field('field')->dateBetween('1999-12-31', '2000-01-32');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfExceptionIsThrownWhenWrongDateFormatIsProvided(): void
    {
        $this->expectException(ValidatorException::class);

        $validator = new Validator([]);
        $validator->field('field')->dateBetween('1999-12-31', '2000-01-32', 'foo');
        $validator->execute();
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->dateBetween('1999-12-31', '2000-01-02');
        $validator->messages('field')->dateBetween('Message is date between');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is date between', $validator->errors()->first('field')?->getMessage());
    }
}
