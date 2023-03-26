<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ConfirmedTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach ([['foo' => '', 'foo_confirmed' => ''], ['foo' => '', 'foo_confirmed' => null], ['foo' => '', 'foo_confirmed' => []]] as $data) {
            $validator = new Validator($data);
            $validator->field('foo')->confirmed();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenInValidValuesAreProvided(): void
    {
        foreach ([['foo' => '', 'foo_confirmed2' => ''], ['foo' => '', 'fooconfirmed' => ''], ['foo' => '', 'foo-confirmed' => ''], ['foo' => '']] as $data) {
            $validator = new Validator($data);
            $validator->field('foo')->confirmed();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNoValuesAreProvided(): void
    {
        $validator = new Validator();
        $validator->field('field')->confirmed();
        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->confirmed();
        $validator->messages('field')->confirmed('Message confirmed');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message confirmed', $validator->errors()->first('field')?->getMessage());
    }
}
