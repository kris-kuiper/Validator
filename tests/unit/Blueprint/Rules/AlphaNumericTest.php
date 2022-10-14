<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class AlphaNumericTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyAlphaNumericValuesAreProvided(): void
    {
        foreach (['abcdefg', 'ABCDEFG', 'AbCdEfG', 2552, '2817334', 'abcd123', 'ABcd123'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->alphaNumeric();
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
            $validator->field('field')->alphaNumeric();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->alphaNumeric();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->alphaNumeric();
        $validator->messages('field')->alphaNumeric('Message alpha numeric');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message alpha numeric', $validator->errors()->first('field')?->getMessage());
    }
}
