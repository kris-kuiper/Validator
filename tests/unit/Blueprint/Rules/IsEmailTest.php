<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsEmailTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyEmailValuesAreProvided(): void
    {
        foreach (['email@domain.com', 'very-long_email-adres-from-a-very_big-company52@very-long-domain-name-from-a-very-big-company.com'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isEmail();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonEmailValuesAreProvided(): void
    {
        foreach ([null, (object) [], 2552, 1, 0, '2817334', 'abcd123'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isEmail();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->isEmail();
        $validator->messages('field')->isEmail('Message is email');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is email', $validator->errors()->first('field')?->getMessage());
    }
}
