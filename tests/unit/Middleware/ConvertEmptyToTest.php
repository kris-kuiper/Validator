<?php

declare(strict_types=1);

namespace tests\unit\Middleware;

use KrisKuiper\Validator\Helpers\ConvertEmpty;
use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ConvertEmptyToTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenEmptyDataIsConvertedToNullAndCompared(): void
    {
        $data = ['field1' => '', 'field2' => [], 'field3' => null];

        $validator = new Validator($data);
        $validator->middleware('field1', 'field2', 'field3')->convertEmptyTo();
        $validator->field('field1')->equals(null);
        $validator->field('field2')->equals(null);
        $validator->field('field3')->equals(null);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenEmptyDataIsConvertedToStringFooAndCompared(): void
    {
        $data = ['field1' => '', 'field2' => [], 'field3' => null];

        $validator = new Validator($data);
        $validator->middleware('field1', 'field2', 'field3')->convertEmptyTo('foo');
        $validator->field('field1')->equals('foo');
        $validator->field('field2')->equals('foo');
        $validator->field('field3')->equals('foo');

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenEmptyStringsAreConvertedToNullAndCompared(): void
    {
        $data = ['field1' => '', 'field2' => [], 'field3' => null];

        $validator = new Validator($data);
        $validator->middleware('field1', 'field2', 'field3')->convertEmptyTo(null, ConvertEmpty::CONVERT_EMPTY_STRING);
        $validator->field('field1')->equals(null);
        $validator->field('field2')->equals([]);
        $validator->field('field3')->equals(null);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenEmptyArraysAreConvertedToNullAndCompared(): void
    {
        $data = ['field1' => '', 'field2' => [], 'field3' => null];

        $validator = new Validator($data);
        $validator->middleware('field1', 'field2', 'field3')->convertEmptyTo(null, ConvertEmpty::CONVERT_EMPTY_ARRAY);
        $validator->field('field1')->equals('');
        $validator->field('field2')->equals(null);
        $validator->field('field3')->equals(null);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNullValuesAreConvertedToStringFooAndCompared(): void
    {
        $data = ['field1' => '', 'field2' => [], 'field3' => null];

        $validator = new Validator($data);
        $validator->middleware('field1', 'field2', 'field3')->convertEmptyTo('foo', ConvertEmpty::CONVERT_NULL);
        $validator->field('field1')->equals('');
        $validator->field('field2')->equals([]);
        $validator->field('field3')->equals('foo');

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNestedArraysWithEmptyValuesAreConvertedToNullAndCompared(): void
    {
        $data = ['foo' => ['bar' => '']];

        $validator = new Validator($data);
        $validator->middleware('foo')->convertEmptyTo();
        $validator->field('foo.bar')->equals(null);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNestedArraysWithEmptyValuesAreNotConvertedToNullAndCompared(): void
    {
        $data = ['foo' => ['bar' => '']];

        $validator = new Validator($data);
        $validator->middleware('foo')->convertEmptyTo(recursive: false);
        $validator->field('foo.bar')->equals('');

        $this->assertTrue($validator->execute());
    }
}
