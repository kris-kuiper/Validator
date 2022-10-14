<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class TimezoneTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenStringValuesAreProvided(): void
    {
        foreach (['Africa/Abidjan', 'Africa/Accra', 'Africa/Addis_Ababa', 'Africa/Algiers', 'Africa/Asmara'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->timezone();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingCaseInsensitive(): void
    {
        foreach (['Africa/Abidjan', 'africa/Accra', 'AfriCA/Addis_Ababa', 'Africa/AlGIERs', 'AfriCa/AsMara'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->timezone(true);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenUsingCaseInsensitive(): void
    {
        foreach (['AfrIca/Abidjan', 'africa/Accra', 'AfriCA/Addis_Ababa', 'Africa/AlGIERs', 'AfriCa/AsMara'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->timezone();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonStringValuesAreProvided(): void
    {
        foreach ([[], (object) [], null, true, false, 0, 123, 52.25, -24, '', 'Foo/Bar'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->timezone();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => []]);
        $validator->field('field')->timezone();
        $validator->messages('field')->timezone('Message is timezone');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is timezone', $validator->errors()->first('field')?->getMessage());
    }
}
