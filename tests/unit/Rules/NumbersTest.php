<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class NumbersTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyBoolValuesAreProvided(): void
    {
        foreach (['a1', '1', 1, 'This is a test 8', 'Foo 5.2', 5.2, -5.2, -3, 3] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsNumber();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonBoolValuesAreProvided(): void
    {
        foreach ([null, (object) [], true, false, 'abcd', 'ABCD'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->containsNumber();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->containsNumber();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->containsNumber();
        $validator->messages('field')->numbers('Message numbers');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message numbers', $validator->errors()->first('field')?->getMessage());
    }
}
