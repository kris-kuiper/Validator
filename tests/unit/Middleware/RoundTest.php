<?php

declare(strict_types=1);

namespace tests\unit\Middleware;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class RoundTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingSimpleFieldValue(): void
    {
        $data = ['field' => '2.5'];

        $validator = new Validator($data);
        $validator->middleware('field')->round();
        $validator->field('field')->equals('3', true);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectValidatedDataIsReturnedWhenUsingThreeDimensionalArrayValues(): void
    {
        $data = ['options' => [0, 1, -2, '4.23', '-5.2', '-2,3', 5.2, 'a', true, false, '', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar'], '5.5', 5.5]];

        $validator = new Validator($data);
        $validator->middleware('options.*')->round();

        $this->assertTrue($validator->execute());
        $this->assertEquals(['options' => [0.0, 1.0, -2.0, '4', '-5', '-2,3', 5.0, 'a', true, false, '', null, [], (object) [], 2552.0, [1, 2], ['a', 'b'], ['foo' => 'bar'], '6', 6.0]], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectValidatedDataIsReturnedWhenUsingThreeDimensionalArrayValuesWithPrecision(): void
    {
        $data = ['options' => [0, 1, -2, '4.23', '-5.2', 1.2, 3.3333, '1.2', '3.3333']];

        $validator = new Validator($data);
        $validator->middleware('options.*')->round(2);

        $this->assertTrue($validator->execute());
        $this->assertSame(['options' => [0.0, 1.0, -2.0, '4.23', '-5.2', 1.2, 3.33, '1.2', '3.33']], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectValidatedDataIsReturnedWhenUsingThreeDimensionalArrayValuesWithModeHalfDown(): void
    {
        $data = ['options' => [2.5, '2.5']];

        $validator = new Validator($data);
        $validator->middleware('options.*')->round(0, PHP_ROUND_HALF_DOWN);

        $this->assertTrue($validator->execute());
        $this->assertSame(['options' => [2.0, '2']], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectValidatedDataIsReturnedWhenUsingThreeDimensionalArrayValuesWithModeEven(): void
    {
        $data = ['options' => [1.5, -1.5, '1.5', '-1.5']];

        $validator = new Validator($data);
        $validator->middleware('options.*')->round(0, PHP_ROUND_HALF_EVEN);

        $this->assertTrue($validator->execute());
        $this->assertSame(['options' => [2.0, -2.0, '2', '-2']], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectValidatedDataIsReturnedWhenUsingThreeDimensionalArrayValuesWithModeOdd(): void
    {
        $data = ['options' => [1.5, -1.5, '1.5', '-1.5']];

        $validator = new Validator($data);
        $validator->middleware('options.*')->round(0, PHP_ROUND_HALF_ODD);

        $this->assertTrue($validator->execute());
        $this->assertSame(['options' => [1.0, -1.0, '1', '-1']], $validator->validatedData()->toArray());
    }
}
