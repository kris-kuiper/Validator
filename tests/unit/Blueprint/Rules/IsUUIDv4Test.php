<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsUUIDv4Test extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyUUIDv4ValuesAreProvided(): void
    {
        foreach (['391a48a1-d92d-45a6-9235-9ca939c3554a', '40a0e2de-7051-410d-b2a0-6aa272f31297', '0588f70c-0687-46b4-a5f2-bbeca69b5f32'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isUUIDv4();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonUUIDv4ValuesAreProvided(): void
    {
        foreach ([null, (object) [], 2552, 1, 0, '2817334', 'abcd123', '95fa2bd2-fbdc-11ec-b939-0242ac120002', 'ed7907b5-d843-3370-b0bc-8f77b5f0f446', '6fad3a7b-161b-5e10-b265-8d522f3f35b5'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isUUIDv4();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->isUUIDv4();
        $validator->messages('field')->isUUIDv4('Message is uuid v4');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is uuid v4', $validator->errors()->first('field')?->getMessage());
    }
}
