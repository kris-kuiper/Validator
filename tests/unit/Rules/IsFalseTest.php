<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsFalseTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyFalseValuesAreProvided(): void
    {
        $validator = new Validator(['field' => false]);
        $validator->field('field')->isFalse();
        $validator->execute();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonFalseValuesAreProvided(): void
    {
        foreach ([(object) [], 2552, 1, 0, '2817334', 'abcd123', ' ', true, 0, '0'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isFalse();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => ' ']);
        $validator->field('field')->isFalse();
        $validator->messages('field')->isFalse('Message is empty');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is empty', $validator->errors()->first('field')?->getMessage());
    }
}
