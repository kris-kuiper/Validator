<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class RequiredWithAllTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenAgeIsNullWhileRequiredWithAllFieldsAreNotEmpty(): void
    {
        $validator = new Validator([
            'age' => null,
            'name' => 'Brenda',
            'date' => [
                'day' => 28,
                'month' => 3,
                'year' => 1952
            ]
        ]);

        $validator->field('age')->requiredWithAll('name', 'date.*');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testBlaat(): void
    {
        $validator = new Validator([]);

        $validator->field('age')->requiredWithAll('foo', 'bar')->isString();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenAgeIsNullAndMonthIsNull(): void
    {
        $validator = new Validator([
            'age' => null,
            'name' => 'Brenda',
            'date' => [
                'day' => 28,
                'month' => null,
                'year' => 1952
            ]
        ]);

        $validator->field('age')->requiredWithAll('name', 'date.*');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenAgeIsNotEmptyAndMonthIsNull(): void
    {
        $validator = new Validator([
            'age' => 67,
            'name' => 'Brenda',
            'date' => [
                'day' => 28,
                'month' => null,
                'year' => 1952
            ]
        ]);

        $validator->field('age')->requiredWithAll('name', 'date.*');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenAgeIsNotEmptyAndRequiredWithAllFieldsAsWildcardAreNotEmpty(): void
    {
        $validator = new Validator([
            'age' => 67,
            'name' => 'Brenda',
            'date' => [
                'day' => 28,
                'month' => 3,
                'year' => 1952
            ]
        ]);

        $validator->field('age')->requiredWithAll('name', 'date.*');
        $this->assertTrue($validator->execute());
    }


    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenAgeIsNotEmptyAndRequiredWithAllFieldsAreNotEmpty(): void
    {
        $validator = new Validator([
            'age' => 67,
            'name' => 'Brenda',
            'day' => 28,
            'month' => 3,
            'year' => 1952
        ]);

        $validator->field('age')->requiredWithAll('name', 'day', 'month', 'year');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIsValidationFailsWhenAgeIsEmptyString(): void
    {
        $validator = new Validator([
            'age' => '',
            'name' => 'Brenda',
            'day' => 28,
            'month' => 3,
            'year' => 1952
        ]);

        $validator->field('age')->requiredWithAll('name', 'day', 'month', 'year');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIsValidationFailsWhenAgeIsNotProvided(): void
    {
        $validator = new Validator([
            'name' => 'Brenda',
            'day' => 28,
            'month' => 3,
            'year' => 1952
        ]);

        $validator->field('age')->requiredWithAll('name', 'day', 'month', 'year');
        $this->assertFalse($validator->execute());
    }


    /**
     * @throws ValidatorException
     */
    public function testIsValidationFailsWhenAgeIsEmptyArray(): void
    {
        $validator = new Validator([
            'age' => [],
            'name' => 'Brenda',
            'day' => 28,
            'month' => 3,
            'year' => 1952
        ]);

        $validator->field('age')->requiredWithAll('name', 'day', 'month', 'year');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIsValidationPassesWhenSomeFieldsAreEmptyStrings(): void
    {
        $validator = new Validator([
            'age' => '',
            'name' => '',
            'day' => '',
            'month' => 3,
            'year' => 1952
        ]);

        $validator->field('age')->requiredWithAll('name', 'day', 'month', 'year');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIsValidationPassesWhenAllFieldsAreEmptyStrings(): void
    {
        $validator = new Validator([
            'age' => '',
            'name' => '',
            'day' => '',
            'month' => '',
            'year' => ''
        ]);

        $validator->field('age')->requiredWithAll('name', 'day', 'month', 'year');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIsValidationPassesAgeIsNotEmptyAndRequiredWithAllFieldsAreEmpty(): void
    {
        $validator = new Validator([
            'age' => 67,
            'name' => '',
            'day' => '',
            'month' => '',
            'year' => ''
        ]);

        $validator->field('age')->requiredWithAll('name', 'day', 'month', 'year');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testValidationPassesWhenNonExistingFieldIsRequiredToTriggerButIsNotPresent(): void
    {
        $validator = new Validator([
            'age' => '',
            'name' => 'foo',
            'day' => 'foo',
            'month' => 'foo',
            'year' => ''
        ]);

        $validator->field('age')->requiredWithAll('name', 'day', 'month', 'non-existing');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testValidationPassesWhenAgeIsProvidedAndNonExistingFieldIsRequiredToTriggerButIsNotPresent(): void
    {
        $validator = new Validator([
            'age' => 21,
            'name' => 'asdf',
            'day' => 'asdf',
            'month' => 'asdf',
            'year' => ''
        ]);

        $validator->field('age')->requiredWithAll('name', 'day', 'month', 'non-existing');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenAgeIsNotProvidedAndAllRequiredWithFieldsAreZero(): void
    {
        $validator = new Validator([
            'age' => '',
            'name' => 0,
            'day' => 0,
            'month' => 0,
            'year' => 0
        ]);

        $validator->field('age')->requiredWithAll('name', 'day', 'month');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['foo' => 'bar']);
        $validator->field('field')->requiredWithAll('foo');
        $validator->messages('field')->requiredWithAll('Message required with all');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message required with all', $validator->errors()->first('field')?->getMessage());
    }
}
