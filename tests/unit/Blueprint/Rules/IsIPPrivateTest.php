<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsIPPrivateTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyPrivateIPAddressValuesAreProvided(): void
    {
        foreach (['::1', '192.168.1.1', '127.0.0.1', '255.255.255.255'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isIPPrivate();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonPrivateIPAddressValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, '1.1.1.1', '83.84.85.86'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isIPPrivate();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => ' ']);
        $validator->field('field')->isIPPrivate();
        $validator->messages('field')->isIPPrivate('Message is ip private');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is ip private', $validator->errors()->first('field')?->getMessage());
    }
}
