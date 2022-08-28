<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class SubstrTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenUsingSimpleFieldValue(): void
    {
        $data = ['field' => 'foo'];

        $validator = new Validator($data);
        $validator->middleware('field')->substr(1);
        $validator->field('field')->equals('oo', true);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenPassingLength(): void
    {
        $data = ['field' => 'foo'];

        $validator = new Validator($data);
        $validator->middleware('field')->substr(1, 1);
        $validator->field('field')->equals('o', true);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenPassingNegativeOffset(): void
    {
        $data = ['field' => '0123456789'];

        $validator = new Validator($data);
        $validator->middleware('field')->substr(-9, 2);
        $validator->field('field')->equals('12', true);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldRetrieveCorrectValidatedDataWhenUsingThreeDimensionalArrayValues(): void
    {
        $data = ['options' => [0, 1, true, false, '', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar']]];

        $validator = new Validator($data);
        $validator->middleware('options.*')->substr(0);

        $this->assertTrue($validator->execute());
        $this->assertEquals(['options' => [0, 1, true, false, '', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar']]], $validator->validatedData()->toArray());
    }
}
