<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class BetweenTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCorrectValuesAreProvided(): void
    {
        foreach (['50', 50, '50.52', 50.52] as $data) {
            $validator = new Validator(['age' => $data]);
            $validator->field('age')->between(18, 100);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoCorrectValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], 2552, true, '2817334', -25, 5.52, '', ' ', '20,20'] as $data) {
            $validator = new Validator(['age' => $data]);
            $validator->field('age')->between(18, 100);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenSubFieldNamesAreValid(): void
    {
        $validator = new Validator([
            'people' => [
                ['name' => 'Brenda', 'age' => 67],
                ['name' => 'Smith', 'age' => 52]
            ]
        ]);

        $validator->field('people.*.age')->between(18, 100);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOneSubFieldNamesIsInvalid(): void
    {
        $validator = new Validator([
            'people' => [
                ['name' => 'Brenda', 'age' => 67],
                ['name' => 'Smith', 'age' => 122]
            ]
        ]);

        $validator->field('people.*.age')->between(18, 100);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOneSubFieldNamesIsNull(): void
    {
        $validator = new Validator([
            'people' => [
                ['name' => 'Brenda', 'age' => 67],
                ['name' => 'Smith', 'age' => null]
            ]
        ]);

        $validator->field('people.*.age')->between(18, 100);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldReturnCorrectMessageWhenCustomMessageIsSet(): void
    {
        $validator = new Validator();
        $validator->field('field')->between(1, 2);
        $validator->messages('field')->between('Message between');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message between', $validator->errors()->first('field')?->getMessage());
    }
}
