<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ProhibitedTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach([null, '', []] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator->field('field')->prohibited();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach([(object) [], 2552, true, false, '2817334', -25, 5.52, ' ', '20,20'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator->field('field')->prohibited();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->prohibited();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => true]);
        $validator->field('field')->prohibited();
        $validator->messages('field')->prohibited('Message prohibited');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message prohibited', $validator->errors()->first('field')?->getMessage());
    }
}
