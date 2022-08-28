<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsIPTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyIPAddressValuesAreProvided(): void
    {
        foreach (['::1', '192.168.1.1', '127.0.0.1', '1.1.1.1', '255.255.255.255', '2001:0db8:85a3:0000:0000:8a2e:0370:7334'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isIP();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonIPAddressValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, '255.255.255.256', '20010:0db8:85a3:0000:0000:8a2e:0370:7334'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isIP();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => ' ']);
        $validator->field('field')->isIP();
        $validator->messages('field')->isIP('Message is ip address');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is ip address', $validator->errors()->first('field')?->getMessage());
    }
}
