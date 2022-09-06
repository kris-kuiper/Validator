<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class JSONTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyJSONValuesAreProvided(): void
    {
        foreach (['[]', '{"foo":"bar"}'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->json();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonJSONValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, '{"foo":"bar"'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->json();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => ' ']);
        $validator->field('field')->json();
        $validator->messages('field')->json('Message is json');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is json', $validator->errors()->first('field')?->getMessage());
    }
}
