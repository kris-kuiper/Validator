<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use countable;
use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class CountableTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyCountableValuesAreProvided(): void
    {
        $class = new class implements countable {
            public function count(): int
            {
                return 0;
            }
        };

        foreach ([[], $class] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->countable();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonCountableValuesAreProvided(): void
    {
        foreach ([null, (object) [], 2552, 1, 0, '2817334', 'abcd123'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->countable();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->countable();
        $validator->messages('field')->countable('Message is countable');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is countable', $validator->errors()->first('field')?->getMessage());
    }
}
