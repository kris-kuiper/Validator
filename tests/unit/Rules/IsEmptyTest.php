<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsEmptyTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyEmptyValuesAreProvided(): void
    {
        foreach ([[], '', null] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isEmpty();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonEmptyValuesAreProvided(): void
    {
        foreach ([(object) [], 2552, 1, 0, '2817334', 'abcd123', ' ', true, false, 0, '0'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isEmpty();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => ' ']);
        $validator->field('field')->isEmpty();
        $validator->messages('field')->isEmpty('Message is empty');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is empty', $validator->errors()->first('field')?->getMessage());
    }
}
