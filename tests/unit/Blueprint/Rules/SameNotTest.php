<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class SameNotTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        $validator = new Validator(['field' => '1', 'field2' => '2']);
        $validator->field('field')->sameNot('field2');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingMultipleFields(): void
    {
        $validator = new Validator(['field' => '1', 'field2' => '1', 'field3' => '2']);
        $validator->field('field')->sameNot('field2', 'field3');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenUsingMultipleFields(): void
    {
        $validator = new Validator(['field' => '1', 'field2' => '1', 'field3' => '1']);
        $validator->field('field')->sameNot('field2', 'field3');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenTwoDifferentFieldValuesAreProvided(): void
    {
        $validator = new Validator(['field' => '1', 'field2' => '1']);
        $validator->field('field')->sameNot('field2');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([(object) [], [], -10, false, true, '-10', 1, 2.5] as $data) {
            $validator = new Validator(['field' => $data, 'field2' => 52]);
            $validator->field('field')->sameNot('field2');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->sameNot('field2');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field1' => null]);
        $validator->field('field1')->sameNot('field2');
        $validator->messages('field1')->sameNot('Message same not');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message same not', $validator->errors()->first('field1')?->getMessage());
    }
}
