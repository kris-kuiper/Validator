<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class UUIDv5Test extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyUUIDv5ValuesAreProvided(): void
    {
        foreach (['6fad3a7b-161b-5e10-b265-8d522f3f35b5', '425cb93b-2a12-5d90-85be-3b75601c409a', '8c7a80eb-27dc-5fc2-b8fb-9c5ee63b462e'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->uuidv5();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonUUIDv5ValuesAreProvided(): void
    {
        foreach ([null, (object) [], 2552, 1, 0, '2817334', 'abcd123', '95fa2bd2-fbdc-11ec-b939-0242ac120002', 'ed7907b5-d843-3370-b0bc-8f77b5f0f446', '391a48a1-d92d-45a6-9235-9ca939c3554a'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->uuidv5();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->uuidv5();
        $validator->messages('field')->uuidv5('Message is uuid v5');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is uuid v5', $validator->errors()->first('field')?->getMessage());
    }
}
