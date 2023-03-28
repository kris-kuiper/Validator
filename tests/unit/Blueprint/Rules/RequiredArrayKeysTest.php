<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class RequiredArrayKeysTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidStringValuesAreProvided(): void
    {
        $validator = new Validator(['field' => ['foo' => 'bar', 'quez' => 'bazz']]);
        $validator->field('field')->requiredArrayKeys('foo', 'quez');
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidIntegerValuesAreProvided(): void
    {
        $validator = new Validator(['field' => [25 => 'foo', 52 => 'bar']]);
        $validator->field('field')->requiredArrayKeys(25, 52);
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInvalidValuesAreProvided(): void
    {
        $validator = new Validator(['field' => []]);
        $validator->field('field')->requiredArrayKeys('foo');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNotAllKeysArePresent(): void
    {
        $validator = new Validator(['field' => ['foo' => 'bar']]);
        $validator->field('field')->requiredArrayKeys('foo', 'quez');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonArrayIsProvided(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->requiredArrayKeys('foo');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->requiredArrayKeys('foo');
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->requiredArrayKeys('foo');
        $validator->messages('field')->requiredArrayKeys('Message in');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message in', $validator->errors()->first('field')?->getMessage());
    }
}
