<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class PresentTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenTrueValuesAreProvided(): void
    {
        $validator = new Validator(['field' => null]);
        $validator->field('field')->present();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonTrueValuesAreProvided(): void
    {
        $validator = new Validator(['field' => null]);
        $validator->field('non-existing')->present();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->present();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => null]);
        $validator->field('non-existing')->present();
        $validator->messages('non-existing')->present('Message present');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message present', $validator->errors()->first('non-existing')?->getMessage());
    }
}
