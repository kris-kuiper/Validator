<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class CombineTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCombiningFieldsWithExpectedDateFormat(): void
    {
        $data = ['year' => '1952', 'month' => '03', 'day' => '28'];

        $validator = new Validator($data);
        $validator->combine('year', 'month', 'day')->glue('-')->alias('date');
        $validator->field('date')->date();

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCombiningFieldsDifferentDateFormats(): void
    {
        $data = ['year' => '1952', 'month' => '03', 'day' => '28'];

        $validator = new Validator($data);
        $validator->combine('year', 'month', 'day')->glue('-')->alias('date');
        $validator->field('date')->date('d-m-Y');

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCombiningMissingExpectedFieldValues(): void
    {
        $data = ['year' => '1952', 'month' => '03'];

        $validator = new Validator($data);
        $validator->combine('year', 'month', 'day')->glue('-')->alias('date');
        $validator->field('date')->date();

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCombiningFieldsWithFormatMethod(): void
    {
        $data = ['year' => '1952', 'month' => '03', 'day' => '28'];

        $validator = new Validator($data);
        $validator->combine('year', 'month', 'day')->format(':year:year|:month:month|:day:day')->alias('date');
        $validator->field('date')->equals($data['year'] . $data['year'] . '|' . $data['month'] . $data['month'] . '|' . $data['day'] . $data['day']);

        $this->assertTrue($validator->execute());
    }


    /**
     * @throws ValidatorException
     */
    public function testIfValidationsThrowsExceptionWhenWrongFormatTypeIsProvided(): void
    {
        $this->expectException(ValidatorException::class);

        $data = ['year' => '1952', 'month' => '03', 'day' => '28'];

        $validator = new Validator($data);
        $validator->combine('year', 'month', 'day')->format(':week')->alias('date');
        $validator->field('date')->equals(null);

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfAliasValueIsReturnedWhenCombiningFieldsWhileFieldNameAlreadyExists(): void
    {
        $data = [
            'date' => '2000-1-1',
            'year' => 1952,
            'month' => 3,
            'day' => 28,
        ];

        $validator = new Validator($data);
        $validator->combine('day', 'month', 'year')->glue('-')->alias('date');
        $validator->field('date')->date('Y-j-d');
        $validator->execute();

        $output = ['date' => '28-3-1952'];

        $this->assertEquals($output, $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCombineIsIgnoredWhenAliasIsNotProvided(): void
    {
        $data = [];
        $validator = new Validator($data);
        $validator->combine('day', 'month', 'year');
        $validator->field('date')->date('Y-j-d');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCombineIsIgnoredWhenAliasAndFieldsAreNotProvided(): void
    {
        $data = [];
        $validator = new Validator($data);
        $validator->combine('day', 'month', 'year');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCombineAliasOverwritesMultiDimensionalArray(): void
    {
        $data = [
            'date_of_birth' => [
                'day' => '28',
                'month' => '3',
                'year' => '1952'
            ]
        ];

        $validator = new Validator($data);
        $validator->combine('date_of_birth.year', 'date_of_birth.month', 'date_of_birth.day')->glue('-')->alias('date_of_birth');
        $validator->middleware('date_of_birth.month', 'date_of_birth.day')->leadingZero();
        $validator->field('date_of_birth')->date()->after('1900-01-01')->before(date('Y-m-d'));

        $validator->execute();
        $this->assertTrue($validator->execute());
    }
}
