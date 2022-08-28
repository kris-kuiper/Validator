<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class RequiredWithTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldIsProvided(): void
    {
        $validator = new Validator([
            'name' => 'Morris',
        ]);

        $validator->field('age')->requiredWith('name');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWithAgeWhenOtherFieldIsProvided(): void
    {
        $validator = new Validator([
            'age' => '',
            'name' => 'Morris',
        ]);

        $validator->field('age')->requiredWith('name');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldIsEmptyString(): void
    {
        $validator = new Validator([
            'name' => '',
        ]);

        $validator->field('age')->requiredWith('name');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWithAgeWhenOtherFieldIsEmptyString(): void
    {
        $validator = new Validator([
            'age' => 67,
            'name' => '',
        ]);

        $validator->field('age')->requiredWith('name');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldIsNull(): void
    {
        $validator = new Validator([
            'name' => null,
        ]);

        $validator->field('age')->requiredWith('name');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWithAgeWhenOtherFieldIsNull(): void
    {
        $validator = new Validator([
            'age' => 67,
            'name' => null,
        ]);

        $validator->field('age')->requiredWith('name');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldIsEmptyArray(): void
    {
        $validator = new Validator([
            'name' => [],
        ]);

        $validator->field('age')->requiredWith('name');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWithAgeWhenOtherFieldIsEmptyArray(): void
    {
        $validator = new Validator([
            'age' => 67,
            'name' => [],
        ]);

        $validator->field('age')->requiredWith('name');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldsAreProvided(): void
    {
        $validator = new Validator([
            'name' => 'Morris',
            'hobby' => 'swimming',
        ]);

        $validator->field('age')->requiredWith('name', 'hobby');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldsAreEmptyStrings(): void
    {
        $validator = new Validator([
            'name' => '',
            'hobby' => '',
        ]);

        $validator->field('age')->requiredWith('name', 'hobby');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldsAreNull(): void
    {
        $validator = new Validator([
            'name' => null,
            'hobby' => null,
        ]);

        $validator->field('age')->requiredWith('name', 'hobby');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldsAreEmptyArrays(): void
    {
        $validator = new Validator([
            'name' => [],
            'hobby' => [],
        ]);

        $validator->field('age')->requiredWith('name', 'hobby');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldsAreEmpty(): void
    {
        $validator = new Validator([
            'name' => [],
            'hobby' => '',
            'street' => null,
        ]);

        $validator->field('age')->requiredWith('name', 'hobby', 'street');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldsAreNotProvided(): void
    {
        $validator = new Validator([]);
        $validator->field('age')->requiredWith('name', 'hobby', 'street');

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldsAreNotEmpty(): void
    {
        $validator = new Validator([
            'name' => ['1'],
            'hobby' => '1',
            'street' => '1',
        ]);

        $validator->field('age')->requiredWith('name', 'hobby', 'street');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNotAllFieldsAreFilled(): void
    {
        $validator = new Validator([
            'name' => ['1'],
            'hobby' => '',
            'street' => '1',
        ]);

        $validator->field('age')->requiredWith('name', 'hobby', 'street');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenAllFieldsAreFilled(): void
    {
        $validator = new Validator([
            'name' => 'Morris',
            'hobbies' => ['swimming', 'programming'],
        ]);

        $validator->field('age')->requiredWith('name', 'hobbies.*');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenUsingCombinationOfNonExistingAndExistingFields(): void
    {
        $validator = new Validator([
            'name' => 'Morris'
        ]);

        $validator->field('age')->requiredWith('non-existing', 'non-existing-2', 'name');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['foo' => '1']);
        $validator->field('field')->requiredWith('foo');
        $validator->messages('field')->requiredWith('Message required with');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message required with', $validator->errors()->first('field')->getMessage());
    }
}
