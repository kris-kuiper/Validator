<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Rules\ActiveURL;
use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ActiveURLTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCorrectValuesAreProvided(): void
    {
        $validator = $this->createMock(Validator::class);
        $validator->method('execute')->willReturn(true);
        $validator->field('url')->activeURL();

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenIncorrectValuesAreProvided(): void
    {
        $validator = $this->createMock(Validator::class);
        $validator->method('execute')->willReturn(false);
        $validator->field('url')->activeURL();
        $validator->messages('field')->after('Message active URL');

        $this->assertFalse($validator->execute());
    }


    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCorrectValuesAreProvided2(): void
    {
        $activeURL = new ActiveURL();
        $this->assertFalse($activeURL->isValid());
        $this->assertSame(ActiveURL::NAME, $activeURL->getName());
    }
}
