<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class CountBetweenTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([[1], [1, 2], [1, 2, 3]] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->countBetween(1, 3);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], ['a', 'b', 'c', 'd'], 2552, true, '2817334'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->countBetween(1, 3);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->countBetween(1, 3);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->countBetween(1, 3);
        $validator->messages('field')->countBetween('Message count between');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message count between', $validator->errors()->first('field')->getMessage());
    }
}
