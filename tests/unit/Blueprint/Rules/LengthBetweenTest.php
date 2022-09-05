<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class LengthBetweenTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['123', '1234', '12345', 123, 1234, 12345] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->lengthBetween(3, 5);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, 1, 12, '1', '12', '123456'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->lengthBetween(3, 5);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->lengthBetween(3, 5);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->lengthBetween(3, 5);
        $validator->messages('field')->lengthBetween('Message length between');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message length between', $validator->errors()->first('field')?->getMessage());
    }
}
