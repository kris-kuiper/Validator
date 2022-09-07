<?php

declare(strict_types=1);

namespace tests\unit\Middleware;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ToLowercaseTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenUsingSimpleFieldValue(): void
    {
        $data = ['field' => 'UPPERCASE'];

        $validator = new Validator($data);
        $validator->middleware('field')->toLowercase();
        $validator->field('field')->equals('uppercase');

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldRetrieveCorrectValidatedDataWhenUsingThreeDimensionalArrayValues(): void
    {
        $data = ['options' => ['ONE', 'TWO', 'THREE']];

        $validator = new Validator($data);
        $validator->middleware('options.*')->toLowercase();

        $this->assertTrue($validator->execute());
        $this->assertSame(['options' => ['one', 'two', 'three']], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenUsingNonStringValues(): void
    {
        foreach ([null, [], (object) [], 2552, true, [1, 2], ['a', 'b'], ['foo' => 'bar']] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->middleware('field')->toLowercase();
            $this->assertTrue($validator->execute());
        }
    }
}
