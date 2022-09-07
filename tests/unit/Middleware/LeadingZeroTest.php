<?php

declare(strict_types=1);

namespace tests\unit\Middleware;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class LeadingZeroTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenUsingSimpleFieldValue(): void
    {
        foreach (['1', '2', '3', '4', '5', '6', '7', '8', '9', 1, 2, 3, 4, 5, 6, 7, 8, 9] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->middleware('field')->leadingZero();
            $validator->field('field')->equals('0' . $data, true);

            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldRetrieveCorrectValidatedDataWhenUsingThreeDimensionalArrayValues(): void
    {
        $data = ['options' => [0, 1, true, false, '', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar']]];

        $validator = new Validator($data);
        $validator->middleware('options.*')->leadingZero();

        $this->assertTrue($validator->execute());
        $this->assertEquals(['options' => [0, '01', true, false, '', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar']]], $validator->validatedData()->toArray());
    }
}
