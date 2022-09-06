<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IPv6Test extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyV6IPAddressValuesAreProvided(): void
    {
        foreach (['::1', '2001:0db8:85a3:0000:0000:8a2e:0370:7334'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->ipv6();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonV6IPAddressValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, '1.1.1.1', '83.84.85.86', '192.168.1.1', '127.0.0.1', '255.255.255.255', '255.255.255.256', '20010:0db8:85a3:0000:0000:8a2e:0370:7334'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->ipv6();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => ' ']);
        $validator->field('field')->ipv6();
        $validator->messages('field')->ipv6('Message is ip v6');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is ip v6', $validator->errors()->first('field')?->getMessage());
    }
}
