<?php

declare(strict_types=1);

namespace tests\unit\Middleware;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ToUppercaseTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingSimpleFieldValue(): void
    {
        $data = ['field' => 'lowercase'];

        $validator = new Validator($data);
        $validator->middleware('field')->toUppercase();
        $validator->field('field')->equals('LOWERCASE');

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectValidatedDataIsReturnedWhenUsingThreeDimensionalArrayValues(): void
    {
        $data = ['options' => ['one', 'two', 'three']];

        $validator = new Validator($data);
        $validator->middleware('options.*')->toUppercase();

        $this->assertTrue($validator->execute());
        $this->assertSame(['options' => ['ONE', 'TWO', 'THREE']], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingNonStringValues(): void
    {
        foreach ([null, [], (object) [], 2552, true, [1, 2], ['a', 'b'], ['foo' => 'bar']] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->middleware('field')->toUppercase();
            $this->assertTrue($validator->execute());
        }
    }
}
