<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class RequiredTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenFieldNameIsValid(): void
    {
        $validator = new Validator([
            'age' => 67,
        ]);

        $validator->field('age')->required();
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

        $validator->field('age')->required();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenFieldNameIsEmptyString(): void
    {
        $validator = new Validator([
            'age' => '',
        ]);

        $validator->field('age')->required();
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

        $validator->field('age.*')->required();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOneSubFieldNameIsEmptyString(): void
    {
        $validator = new Validator([
            'age' => [
                'Smith' => '',
                'Morris' => 67,
            ],
        ]);

        $validator->field('age.*')->required();
        $this->assertFalse($validator->execute());
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

        $validator->field('age.*')->required();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsIfAllSubFieldsAreEmpty(): void
    {
        $validator = new Validator([
            'age' => [
                'Smith' => null,
                'Morris' => null,
            ],
        ]);

        $validator->field('age.*')->required();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOneDeepSubFieldNameIsEmpty(): void
    {
        $validator = new Validator([
            'people' => [
                [
                    'name' => 'Smith',
                    'age' => ''
                ],
                [
                    'name' => 'Morris',
                    'age' => 67,
                ]
            ],
        ]);

        $validator->field('people.*.age', '*.*.age')->required()->between(25, 100);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonExistingFieldNameIsProvidedButRequired(): void
    {
        $validator = new Validator([
            'age' => null,
        ]);

        $validator->field('non-existing-field-name')->required();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenFieldIsNullButRequired(): void
    {
        $executed = 0;
        $validator = new Validator([
            'people' => [
                ['name' => 'Smith', 'age' => null]
            ]
        ]);

        $validator->custom('custom', static function () use (&$executed): bool {
            $executed++;
            return true;
        });

        $validator->field('people.*.age')->required()->custom('custom');
        $this->assertFalse($validator->execute());
        $this->assertSame(0, $executed);
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNotAllFieldAreProvidedButRequired(): void
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

        $validator->field('people.*.age')->required()->custom('custom');
        $this->assertFalse($validator->execute());
        $this->assertSame(1, $executed);
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnsUsingFixedKeysAsMessageFieldName(): void
    {
        $validator = new Validator([]);

        $validator->field('people.*.age')->required();
        $validator->messages('*.1.age')->required('custom-message');
        $validator->messages()->required('default-custom-message');

        $this->assertFalse($validator->execute());
        $this->assertSame('default-custom-message', $validator->errors()->first('*.*.age')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturned(): void
    {
        $validator = new Validator([]);

        $validator->field('age')->required();
        $validator->messages('age')->required('custom-message');
        $validator->messages()->required('default-custom-message');

        $this->assertFalse($validator->execute());
        $this->assertSame('custom-message', $validator->errors()->first('age')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedUsingWildcards(): void
    {
        $validator = new Validator([]);

        $validator->field('people.*.age')->required();
        $validator->messages('people.*.age')->required('custom-message');
        $validator->messages()->required('default-custom-message');

        $this->assertFalse($validator->execute());
        $this->assertSame('custom-message', $validator->errors()->first('people.*.age')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenUsingWildcards(): void
    {
        $validator = new Validator([
            'people' => [
                [
                    'name' => 'Smith',
                    'age' => ''
                ],
                [
                    'name' => 'Morris',
                    'age' => 67,
                ]
            ],
        ]);

        $validator->field('people.*.age')->required();
        $validator->messages('people.*.age')->required('custom-message');
        $validator->messages()->required('default-custom-message');

        $this->assertFalse($validator->execute());
        $this->assertSame('custom-message', $validator->errors()->first('people.*.age')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenUsingDoubleWildcards(): void
    {
        $validator = new Validator([
            'people' => [
                [
                    'name' => 'Smith',
                    'age' => ''
                ],
                [
                    'name' => 'Morris',
                    'age' => 67,
                ]
            ],
        ]);

        $validator->field('*.*.age')->required();
        $validator->messages('people.*.age')->required('custom-message');
        $validator->messages()->required('default-custom-message');

        $this->assertFalse($validator->execute());
        $this->assertSame('custom-message', $validator->errors()->first('*.*.age')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNoValuesAreProvidedWillRequiredIsFalse(): void
    {
        $validator = new Validator();
        $validator->field('people.*.age')->required(false)->min(18);

        $this->assertTrue($validator->execute());
    }
}
