<?php

declare(strict_types=1);

namespace tests\unit\Middleware;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ReplaceTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingSimpleFieldValue(): void
    {
        $data = ['field' => '10101010'];

        $validator = new Validator($data);
        $validator->middleware('field')->replace('0', '1');
        $validator->field('field')->equals('11111111', true);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenReplacingSingleNumberAsFloat(): void
    {
        $data = ['field' => 123.456];

        $validator = new Validator($data);
        $validator->middleware('field')->replace('2', '0');
        $validator->field('field')->equals(103.456, true);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenReplacingSingleNumberAsInt(): void
    {
        $data = ['field' => 123];

        $validator = new Validator($data);
        $validator->middleware('field')->replace('2', '0');
        $validator->field('field')->equals(103, true);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenReplacingSingleNumberAsString(): void
    {
        $data = ['field' => '123'];

        $validator = new Validator($data);
        $validator->middleware('field')->replace('2', '0');
        $validator->field('field')->equals('103', true);
        $this->assertTrue($validator->execute());
    }


    /**
     * @throws ValidatorException
     */
    public function testIfCorrectValidatedDataIsReturnedWhenUsingThreeDimensionalArrayValues(): void
    {
        $data = ['options' => [0, 1, -2, '5', '-5', '-2,3', 'a', true, false, '', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar'], 'this 10.3 test']];

        $validator = new Validator($data);
        $validator->middleware('options.*')->replace('test', 'rock');

        $this->assertTrue($validator->execute());
        $this->assertEquals(['options' => [0, 1, -2, '5', '-5', '-2,3', 'a', true, false, '', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar'], 'this 10.3 rock']], $validator->validatedData()->toArray());
    }
}
