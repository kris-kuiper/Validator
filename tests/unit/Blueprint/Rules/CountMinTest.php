<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class CountMinTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([['a', 'b', 'c'], [1, 2, 3], [1, 2, 3, 4, 5], ['foo' => 1, 'bar' => 2, 'quez' => 3]] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->countMin(3);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], 2552, true, '2817334', [1, 2], ['a', 'b'], ['foo' => 'bar']] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->countMin(3);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->countMin(2);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->countMin(2);
        $validator->messages('field')->countMin('Message count min');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message count min', $validator->errors()->first('field')->getMessage());
    }
}
