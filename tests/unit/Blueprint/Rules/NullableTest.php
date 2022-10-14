<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class NullableTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenFieldNameIsValid(): void
    {
        $validator = new Validator([
            'age' => 67,
        ]);

        $validator->field('age')->nullable();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenFieldNameIsNull(): void
    {
        $validator = new Validator([
            'age' => null,
        ]);

        $validator->field('age')->nullable();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenFieldNameIsNull(): void
    {
        $validator = new Validator([
            'age' => null,
        ]);

        $validator->field('age')->nullable(false);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenAllSubFieldNamesAreProvided(): void
    {
        $validator = new Validator([
            'age' => [
                'Smith' => 25,
                'Morris' => 67,
            ],
        ]);

        $validator->field('age.*')->nullable();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOneSubFieldNameIsNull(): void
    {
        $validator = new Validator([
            'age' => [
                'Smith' => null,
                'Morris' => 67,
            ],
        ]);

        $validator->field('age.*')->nullable();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOneSubFieldNameIsNull(): void
    {
        $validator = new Validator([
            'age' => [
                'Smith' => null,
                'Morris' => 67,
            ],
        ]);

        $validator->field('age.*')->nullable(false);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesIfAllSubFieldsNull(): void
    {
        $validator = new Validator([
            'age' => [
                'Smith' => null,
                'Morris' => null,
            ],
        ]);

        $validator->field('age.*')->nullable();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsIfAllSubFieldsNull(): void
    {
        $validator = new Validator([
            'age' => [
                'Smith' => null,
                'Morris' => null,
            ],
        ]);

        $validator->field('age.*')->nullable(false);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOneDeepSubFieldNameIsNull(): void
    {
        $validator = new Validator([
            'people' => [
                [
                    'name' => 'Smith',
                    'age' => null
                ],
                [
                    'name' => 'Morris',
                    'age' => 67,
                ]
            ],
        ]);

        $validator->field('people.*.age', '*.*.age')->nullable()->between(25, 100);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNonExistingFieldNameIsProvided(): void
    {
        $validator = new Validator([
            'age' => null,
        ]);

        $validator->field('non-existing-field-name')->nullable();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonExistingFieldNameIsProvided(): void
    {
        $validator = new Validator([
            'age' => null,
        ]);

        $validator->field('non-existing-field-name')->nullable(false);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenFieldIsNull(): void
    {
        $executed = 0;
        $validator = new Validator([
            'people' => [
                [
                    'name' => 'Smith',
                    'age' => null
                ]
            ]
        ]);

        $validator->custom('custom', static function () use (&$executed): bool {
            $executed++;
            return true;
        });

        $validator->field('people.*.age')->nullable()->custom('custom');
        $this->assertTrue($validator->execute());
        $this->assertSame(0, $executed);
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNotAllFieldAreProvided(): void
    {
        $executed = 0;
        $validator = new Validator([
            'people' => [
                ['name' => 'Brenda', 'age' => 67],
                ['name' => 'Smith', 'age' => null]
            ]
        ]);

        $validator->custom('custom', static function () use (&$executed): bool {
            $executed++;
            return true;
        });

        $validator->field('people.*.age')->nullable()->custom('custom');
        $this->assertTrue($validator->execute());
        $this->assertSame(1, $executed);
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnsUsingFixedKeysAsMessageFieldName(): void
    {
        $validator = new Validator([]);

        $validator->field('people.*.age')->nullable(false);
        $validator->messages('*.1.age')->nullable('custom-message');
        $validator->messages()->nullable('default-custom-message');

        $this->assertFalse($validator->execute());
        $this->assertSame('default-custom-message', $validator->errors()->first('*.*.age')->getMessage());
    }
}
