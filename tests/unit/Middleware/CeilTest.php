<?php

declare(strict_types=1);

namespace tests\unit\Middleware;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class CeilTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenUsingSimpleFieldValue(): void
    {
        $data = ['field' => '2.5'];

        $validator = new Validator($data);
        $validator->middleware('field')->ceil();
        $validator->field('field')->equals('3', true);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldRetrieveCorrectValidatedDataWhenUsingThreeDimensionalArrayValues(): void
    {
        $data = ['options' => [0, 1, -2, '4.23', '-5.2', '-2,3', 'a', true, false, '', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar'], 'this 10.3 test']];

        $validator = new Validator($data);
        $validator->middleware('options.*')->ceil();

        $this->assertTrue($validator->execute());
        $this->assertEquals(['options' => [0, 1, -2, '5', '-5', '-2,3', 'a', true, false, '', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar'], 'this 10.3 test']], $validator->validatedData()->toArray());
    }
}
