<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class CountMaxTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], 2552, true, '2817334', [1, 2], ['a', 'b'], ['foo' => 'bar']] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->countMax(2);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([['a', 'b', 'c'], [1, 2, 3], ['foo' => 1, 'bar' => 2, 'quez' => 3]] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->countMax(2);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->countMax(2);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => ['a', 'b', 'c']]);
        $validator->field('field')->countMax(2);
        $validator->messages('field')->countMax('Message count max');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message count max', $validator->errors()->first('field')?->getMessage());
    }
}
