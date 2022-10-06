<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class HexadecimalTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['AB10BC99', 'ab12bc99', 'abcdef0123456789', 'a', 'B'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->hexadecimal();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonValidValuesAreProvided(): void
    {
        foreach ([(object) [], ' ', true, false, '', -2.5, '-1', -0.1, '-0.1', [], 'g', '01234z', '01234Z'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->hexadecimal();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->hexadecimal();
        $validator->messages('field')->hexadecimal('Message is hexadecimal');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is hexadecimal', $validator->errors()->first('field')?->getMessage());
    }
}
