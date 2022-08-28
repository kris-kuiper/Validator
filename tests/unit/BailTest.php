<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Validator;
use PHPUnit\Framework\TestCase;

final class BailTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfSecondRuleIsStoppedExecutedAfterBailing(): void
    {
        $bailed = 0;
        $data = [
            'foo' => 20,
            'bar' => 5
        ];

        $validator = new Validator($data);

        $validator->custom('custom', function () use (&$bailed) {

            $bailed++;
            return true;
        });

        $validator->field('foo')->bail()->between(1, 10)->custom('custom');
        $validator->field('foo')->custom('custom');

        $this->assertFalse($validator->execute());
        $this->assertSame(1, $bailed);
    }


    /**
     * @throws ValidatorException
     */
    public function testIfBailPreventOtherRulesFromExecutingWhenBailMethodIsUsedAnywhere(): void
    {
        $executed = 0;
        $validator = new Validator(['foo' => 25]);

        $custom = static function () use (&$executed) {

            $executed++;
            return false;
        };

        $validator->custom('custom1', $custom);
        $validator->custom('custom2', $custom);
        $validator->custom('custom3', $custom);
        $validator->field('foo')->custom('custom1')->custom('custom2')->bail()->custom('custom3');

        $this->assertFalse($validator->execute());
        $this->assertSame(1, $executed);
    }
}
