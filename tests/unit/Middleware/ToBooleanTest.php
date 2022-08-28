<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ToBooleanTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenUsingSimpleFieldValue(): void
    {
        $data = ['field' => '1'];

        $validator = new Validator($data);
        $validator->middleware('field')->toBoolean();
        $validator->field('field')->equals(true);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldRetrieveCorrectValidatedDataWhenUsingThreeDimensionalArrayValues(): void
    {
        $data = ['options' => [0, 1, 2, '0', '1', '2', true, false, 'true', 'false', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar']]];

        $validator = new Validator($data);
        $validator->middleware('options.*')->toBoolean();

        $this->assertTrue($validator->execute());
        $this->assertSame(['options' => [false, true, true, false, true, true, true, false, true, true, false, false, true, true, true, true, true]], $validator->validatedData()->toArray());
    }
}
