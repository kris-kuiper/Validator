<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class DistinctTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['testing', '', 'tes', 'Test', 'TEST', ' test ', 0, null, true, null, [], (object) [], 2552, true, '2817334', [1, 2], ['a', 'b'], ['a', 'A'], ['foo' => 'bar']] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->distinct();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([[1, 1], ['a', 'a'], ['foo' => 'bar', 'quez' => 'bar']] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->distinct();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->distinct();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => [0, 0]]);
        $validator->field('field')->distinct();
        $validator->messages('field')->distinct('Message distinct');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message distinct', $validator->errors()->first('field')?->getMessage());
    }
}
