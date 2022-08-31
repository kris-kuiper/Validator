<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsScalarTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenScalarValuesAreProvided(): void
    {
        foreach ([true, false, 0, 1, 2.5, -2.5, -1, 'a'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isScalar();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonScalarValuesAreProvided(): void
    {
        foreach ([[], (object) [], null] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isScalar();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => []]);
        $validator->field('field')->isScalar();
        $validator->messages('field')->isScalar('Message is scalar');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is scalar', $validator->errors()->first('field')?->getMessage());
    }
}
