<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsIPv4Test extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyV4IPAddressValuesAreProvided(): void
    {
        foreach (['1.1.1.1', '83.84.85.86', '192.168.1.1', '127.0.0.1', '255.255.255.255'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isIPv4();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonV4IPAddressValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, '::1', '2001:0db8:85a3:0000:0000:8a2e:0370:7334', '255.255.255.256'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isIPv4();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => ' ']);
        $validator->field('field')->isIPv4();
        $validator->messages('field')->isIPv4('Message is ip v4');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is ip v4', $validator->errors()->first('field')?->getMessage());
    }
}
