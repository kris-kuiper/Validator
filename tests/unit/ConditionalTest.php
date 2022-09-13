<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Blueprint\Custom\Current;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Validator;
use PHPUnit\Framework\TestCase;

final class ConditionalTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenBusinessShouldBe1WhenAmountIsGreaterThan99(): void
    {
        $data = [
            'amount' => 100,
            'business' => '0'
        ];

        $validator = new Validator($data);
        $validator->field('business')->conditional(static function (Current $current) {
            return $current->getValue('amount') > 99;
        })->equals('1');

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenBusinessIs0AndAMountIs1(): void
    {
        $data = [
            'amount' => 1,
            'business' => '0'
        ];

        $validator = new Validator($data);
        $validator->field('business')->conditional(static function (Current $current) {
            return $current->getValue('amount') > 99;
        })->equals('1')->between(0, 1);

        $validator->execute();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenMultipleFieldNamesAreProvided(): void
    {
        $data = [
            'product' => 'Laptop',
            'amount' => 100,
            'business' => '1'
        ];

        $validator = new Validator($data);
        $validator->field('business', 'product')->conditional(static function (Current $current) {
            return $current->getValue('amount') > 99;
        })->equals('1');

        $validator->execute();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenMultipleFieldNamesAreProvided(): void
    {
        $data = [
            'product' => '1',
            'amount' => 1,
            'business' => '1'
        ];

        $validator = new Validator($data);
        $validator->field('business', 'product')->conditional(static function (Current $current) {
            return $current->getValue('amount') > 99;
        })->equals('1');

        $validator->execute();
        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenEqualsRuleComesBeforeConditionalRule(): void
    {
        $data = [
            'amount' => 100,
            'business' => '0'
        ];

        $validator = new Validator($data);
        $validator->field('business')->equals('1')->conditional(static function (Current $current) {
            return $current->getValue('amount') > 99;
        });

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenEqualsRuleComesBeforeConditionalRule(): void
    {
        $data = [
            'amount' => 100,
            'business' => '1'
        ];

        $validator = new Validator($data);
        $validator->field('business')->equals('1')->conditional(static function (Current $current) {
            return $current->getValue('amount') > 99;
        });

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenBusinessIsOnlyRequiredWhenConditionalIsTrue(): void
    {
        $validator = new Validator(['amount' => 100]);
        $validator->field('business')->conditional(static function (Current $current) {
            return $current->getValue('amount') > 99;
        })->required();

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenBusinessIsNotRequiredWhenConditionalIsFalse(): void
    {
        $validator = new Validator(['amount' => 1]);
        $validator->field('business')->conditional(static function (Current $current) {
            return $current->getValue('amount') > 99;
        })->required();

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationStillFailsWhenDefiningNewRuleNextToConditionalRuleWhichShouldNotBeExecuted(): void
    {
        $data = [
            'amount' => 1,
            'business' => 1
        ];

        $validator = new Validator($data);
        $validator->field('business')->conditional(static function (Current $current) {
            return $current->getValue('amount') > 99;
        })->min(2);

        $validator->field('business')->equals(2);
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenBusinessIsRequiredWhenConditionalIsTrue(): void
    {
        $data = [
            'amount' => 100,
            'business' => '1'
        ];

        $validator = new Validator($data);
        $validator->field('business')->conditional(static function (Current $current) {
            return $current->getValue('amount') > 99;
        })->required();

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfAllRulesBeforeConditionalAreExecutedAndAllRulesAfterConditionalAreNotExecutedWhenConditionalIsFalse(): void
    {
        $executed = 0;
        $validator = new Validator(['foo' => 25]);

        $custom = static function () use (&$executed) {

            $executed++;
            return true;
        };

        $validator->custom('custom1', $custom);
        $validator->custom('custom2', $custom);
        $validator->field('foo')->custom('custom1')->conditional(static function () {
            return false;
        })->custom('custom2');

        $this->assertTrue($validator->execute());
        $this->assertSame(1, $executed);
    }


    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingMultipleConditionalRules(): void
    {
        $validator = new Validator(['foo' => 25]);
        $validator
            ->field('foo')
            ->conditional(static function () {
                return true;
            })
            ->conditional(static function () {
                return true;
            })
            ->conditional(static function () {
                return true;
            })
            ->min(10);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingMultipleConditionalRulesAndOne(): void
    {
        $validator = new Validator(['foo' => 25]);
        $validator
            ->field('foo')
            ->conditional(static function () {
                return true;
            })
            ->conditional(static function () {
                return false;
            })
            ->conditional(static function () {
                return true;
            })
            ->min(10);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingMultipleConditionalRulesAndAEarlyConditionalReturn(): void
    {
        $validator = new Validator(['foo' => 5]);
        $validator
            ->field('foo')
            ->conditional(static function () {
                return true;
            })
            ->conditional(static function () {
                return false;
            })
            ->conditional(static function () {
                return true;
            })
            ->min(10);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationExecutesAllCustomRulesWhenUsingMultipleConditionalRules(): void
    {
        $executed = 0;
        $validator = new Validator(['foo' => 25]);

        $custom = static function () use (&$executed) {

            $executed++;
            return true;
        };

        $validator->custom('custom1', $custom);
        $validator->custom('custom2', $custom);
        $validator->custom('custom3', $custom);

        $validator
            ->field('foo')
            ->conditional(static function () {
                return true;
            })
            ->custom('custom1')
            ->conditional(static function () {
                return true;
            })
            ->custom('custom2')
            ->conditional(static function () {
                return true;
            })
            ->custom('custom3');

        $this->assertTrue($validator->execute());
        $this->assertSame(3, $executed);
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationExecutesRightAmountOfCustomRulesWhenUsingMultipleConditionalRules(): void
    {
        $executed = 0;
        $validator = new Validator(['foo' => 25]);

        $custom = static function () use (&$executed) {

            $executed++;
            return true;
        };

        $validator->custom('custom1', $custom);
        $validator->custom('custom2', $custom);
        $validator->custom('custom3', $custom);

        $validator
            ->field('foo')
            ->conditional(static function () {
                return true;
            })
            ->custom('custom1')
            ->conditional(static function () {
                return true;
            })
            ->custom('custom2')
            ->conditional(static function () {
                return false;
            })
            ->custom('custom3');

        $this->assertTrue($validator->execute());
        $this->assertSame(2, $executed);
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCacheReturnsCorrectResultWhenUsingConditionalRules(): void
    {
        $validator = new Validator(['foo' => 5]);
        $validator->storage()->set('foo', 'bar');
        $validator
            ->field('foo')
            ->conditional(function (Current $current) {
                $this->assertTrue($current->storage()->has('foo'));
                $this->assertSame('bar', $current->storage()->get('foo'));
                $current->storage()->set('quez', 'bazz');
                return 'bar' === $current->storage()->get('foo');
            })
            ->min(3);

        $this->assertTrue($validator->execute());
        $this->assertTrue($validator->storage()->has('quez'));
        $this->assertSame('bazz', $validator->storage()->get('quez'));
    }
}
