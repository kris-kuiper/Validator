<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class MACAddressTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyMACAddressValuesAreProvided(): void
    {
        foreach (['BB-A6-B0-9C-54-4F', '6E-F7-47-02-95-AD', '6e-f7-47-02-95-ad'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->macAddress();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyMACAddressValuesAreProvidedWithDelimiter(): void
    {
        foreach (['6e:f7:47:02:95:ad', '6E:F7:47:02:95:AD'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->macAddress(':');
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonMACAddressValuesAreProvided(): void
    {
        foreach ([null, (object) [], [], 'abcdef', true, '6g:f7:47:02:95:ad', '6G:F7:47:02:95:AD', '6G-f7-47-02-95-ad'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->macAddress();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => ' ']);
        $validator->field('field')->macAddress();
        $validator->messages('field')->macAddress('Message is mac address');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is mac address', $validator->errors()->first('field')?->getMessage());
    }
}
