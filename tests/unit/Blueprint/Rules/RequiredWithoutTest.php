<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class RequiredWithoutTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldIsProvided(): void
    {
        $validator = new Validator([
            'name' => 'Morris',
        ]);

        $validator->field('age')->requiredWithout('name');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWithAgeWhenOtherFieldIsProvided(): void
    {
        $validator = new Validator([
            'age' => '',
            'name' => 'Morris',
        ]);

        $validator->field('age')->requiredWithout('name');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldIsEmptyString(): void
    {
        $validator = new Validator([
            'name' => '',
        ]);

        $validator->field('age')->requiredWithout('name');
        $this->assertFalse($validator->execute());
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

        $validator->field('age')->requiredWithout('name');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldIsNull(): void
    {
        $validator = new Validator([
            'name' => null,
        ]);

        $validator->field('age')->requiredWithout('name');
        $this->assertFalse($validator->execute());
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

        $validator->field('age')->requiredWithout('name');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldIsEmptyArray(): void
    {
        $validator = new Validator([
            'name' => [],
        ]);

        $validator->field('age')->requiredWithout('name');
        $this->assertFalse($validator->execute());
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

        $validator->field('age')->requiredWithout('name');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldsAreProvided(): void
    {
        $validator = new Validator([
            'name' => 'Morris',
            'hobby' => 'swimming',
        ]);

        $validator->field('age')->requiredWithout('name', 'hobby');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldsAreEmptyStrings(): void
    {
        $validator = new Validator([
            'name' => '',
            'hobby' => '',
        ]);

        $validator->field('age')->requiredWithout('name', 'hobby');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldsAreNull(): void
    {
        $validator = new Validator([
            'name' => null,
            'hobby' => null,
        ]);

        $validator->field('age')->requiredWithout('name', 'hobby');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldsAreEmptyArrays(): void
    {
        $validator = new Validator([
            'name' => [],
            'hobby' => [],
        ]);

        $validator->field('age')->requiredWithout('name', 'hobby');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldsAreEmpty(): void
    {
        $validator = new Validator([
            'name' => [],
            'hobby' => '',
            'street' => null,
        ]);

        $validator->field('age')->requiredWithout('name', 'hobby', 'street');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOtherFieldsAreNotProvided(): void
    {
        $validator = new Validator([]);
        $validator->field('age')->requiredWithout('name', 'hobby', 'street');

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOtherFieldsAreNotEmpty(): void
    {
        $validator = new Validator([
            'name' => ['1'],
            'hobby' => '1',
            'street' => '1',
        ]);

        $validator->field('age')->requiredWithout('name', 'hobby', 'street');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenNotAllFieldsAreFilled(): void
    {
        $validator = new Validator([
            'name' => ['1'],
            'hobby' => '',
            'street' => '1',
        ]);

        $validator->field('age')->requiredWithout('name', 'hobby', 'street');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenAllFieldsAreFilled(): void
    {
        $validator = new Validator([
            'name' => 'Morris',
            'hobbies' => ['swimming', 'programming'],
        ]);

        $validator->field('age')->requiredWithout('name', 'hobbies.*');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenUsingCombinationOfNonExistingAndExistingFields(): void
    {
        $validator = new Validator([
            'name' => 'Morris'
        ]);

        $validator->field('age')->requiredWithout('non-existing', 'non-existing-2', 'name');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator();
        $validator->field('field')->requiredWithout('foo');
        $validator->messages('field')->requiredWithout('Message required without');

        $this->assertFalse($validator->execute());
        $this->assertSame('Message required without', $validator->errors()->first('field')?->getMessage());
    }
}
