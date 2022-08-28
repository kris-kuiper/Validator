<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Validator;
use PHPUnit\Framework\TestCase;

final class ExcludeIfTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenFieldShouldBeExcludedForValidation(): void
    {
        $data = [
            'amount' => 100,
            'business' => '0'
        ];

        $validator = new Validator($data);
        $validator->field('business')->excludeIf('amount', 100)->equals('1');

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenFieldShouldNotBeExcludedForValidation(): void
    {
        $data = [
            'amount' => 100,
            'business' => '0'
        ];

        $validator = new Validator($data);
        $validator->field('business')->excludeIf('amount', 50)->equals('0');

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenFieldShouldNotBeExcludedForValidation(): void
    {
        $data = [
            'amount' => 100,
            'business' => '0'
        ];

        $validator = new Validator($data);
        $validator->field('business')->excludeIf('amount', 50)->equals('1');

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenFieldShouldNotBeExcludedBecauseAmountIsNotSet(): void
    {
        $validator = new Validator([]);
        $validator->field('business')->excludeIf('amount', 50)->equals('1')->required();

        $this->assertFalse($validator->execute());
    }
}
