<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsAlphaNumericTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyAlphaNumericValuesAreProvided(): void
    {
        foreach (['abcdefg', 'ABCDEFG', 'AbCdEfG', 2552, '2817334', 'abcd123', 'ABcd123'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isAlphaNumeric();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonAlphaNumericValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], true, 'abcd_', 'AbC__dEf_G'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isAlphaNumeric();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->isAlphaNumeric();
        $validator->messages('field')->isAlphaNumeric('Message alpha numeric');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message alpha numeric', $validator->errors()->first('field')?->getMessage());
    }
}
