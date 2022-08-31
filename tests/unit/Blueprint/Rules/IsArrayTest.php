<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsArrayTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyArrayValuesAreProvided(): void
    {
        foreach ([[], ['foo'], ['foo' => 'bar', [1, 2, 3]]] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isArray();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonArrayValuesAreProvided(): void
    {
        foreach ([null, (object) [], 2552, true, '2817334', 'abcd123'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isArray();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->isArray();
        $validator->messages('field')->isArray('Message is array');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is array', $validator->errors()->first('field')->getMessage());
    }
}
