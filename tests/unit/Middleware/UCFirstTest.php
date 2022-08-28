<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class UCFirstTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenUsingSimpleFieldValue(): void
    {
        $data = ['field' => 'ucfirst'];

        $validator = new Validator($data);
        $validator->middleware('field')->ucFirst();
        $validator->field('field')->equals('Ucfirst');

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldRetrieveCorrectValidatedDataWhenUsingThreeDimensionalArrayValues(): void
    {
        $data = ['options' => [0, 1, true, false, '', 'foo bar', 'Foo bar', 'Foo Bar', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar']]];

        $validator = new Validator($data);
        $validator->middleware('options.*')->ucFirst();

        $this->assertTrue($validator->execute());
        $this->assertEquals(['options' => [0, 1, true, false, '', 'Foo bar', 'Foo bar', 'Foo Bar', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar']]], $validator->validatedData()->toArray());
    }
}
