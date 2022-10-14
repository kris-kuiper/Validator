<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class AlphaTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyAlphaValuesAreProvided(): void
    {
        foreach (['abcdefg', 'ABCDEFG', 'AbCdEfG'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->alpha();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonAlphaValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], 2552, true, '2817334', 'abcd123', 'abcd_', 'AbC__dEf_G'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->alpha();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->alpha();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->alpha();
        $validator->messages('field')->alpha('Message alpha');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message alpha', $validator->errors()->first('field')?->getMessage());
    }
}
