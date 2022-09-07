<?php

declare(strict_types=1);

namespace tests\unit\Middleware;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ToFloatTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenUsingSimpleFieldValue(): void
    {
        $data = ['field' => '2.5'];

        $validator = new Validator($data);
        $validator->middleware('field')->toFloat();
        $validator->field('field')->equals(2.5, true);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldRetrieveCorrectValidatedDataWhenUsingThreeDimensionalArrayValues(): void
    {
        $data = ['options' => [0, 1, -2, true, false, '', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar']]];

        $validator = new Validator($data);
        $validator->middleware('options.*')->toFloat();

        $this->assertTrue($validator->execute());
        $this->assertSame(['options' => [0.0, 1.0, -2.0, 1.0, 0.0, 0.0, 0.0, 0.0, 0.0, 2552.0, 0.0, 0.0, 0.0]], $validator->validatedData()->toArray());
    }
}
