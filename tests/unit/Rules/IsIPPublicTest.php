<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsIPPublicTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyPublicIPAddressValuesAreProvided(): void
    {
        foreach (['1.1.1.1', '83.84.85.86'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isIPPublic();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonPublicIPAddressValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, '::1', '192.168.1.1', '127.0.0.1', '255.255.255.255'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isIPPublic();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => ' ']);
        $validator->field('field')->isIPPublic();
        $validator->messages('field')->isIPPublic('Message is ip public');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is ip public', $validator->errors()->first('field')?->getMessage());
    }
}
