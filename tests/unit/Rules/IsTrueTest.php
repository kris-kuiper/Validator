<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsTrueTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenTrueValuesAreProvided(): void
    {
        $validator = new Validator(['field' => true]);
        $validator->field('field')->isTrue();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonTrueValuesAreProvided(): void
    {
        foreach ([(object) [], 2552, 0, '2817334', 'abcd123', ' ', false, 1, '1'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isTrue();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->isTrue();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => []]);
        $validator->field('field')->isTrue();
        $validator->messages('field')->isTrue('Message is string');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is string', $validator->errors()->first('field')?->getMessage());
    }
}
