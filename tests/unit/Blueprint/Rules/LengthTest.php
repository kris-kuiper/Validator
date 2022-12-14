<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class LengthTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['12345', 'foo b', 12345, '12,34', '12.34', 12.34] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->length(5);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, 12.345, 12.3] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->length(5);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->length(5);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->length(5);
        $validator->messages('field')->length('Message length');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message length', $validator->errors()->first('field')?->getMessage());
    }
}
