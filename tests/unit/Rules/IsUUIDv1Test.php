<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsUUIDv1Test extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyUUIDv1ValuesAreProvided(): void
    {
        foreach (['95fa2bd2-fbdc-11ec-b939-0242ac120002', 'ab2bfa26-fbdc-11ec-b939-0242ac120002', 'ab2bdb04-fbdc-11ec-b939-0242ac120002'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isUUIDv1();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonUUIDv1ValuesAreProvided(): void
    {
        foreach ([null, (object) [], 2552, 1, 0, '2817334', 'abcd123', 'ed7907b5-d843-3370-b0bc-8f77b5f0f446', '391a48a1-d92d-45a6-9235-9ca939c3554a', '6fad3a7b-161b-5e10-b265-8d522f3f35b5'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isUUIDv1();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->isUUIDv1();
        $validator->messages('field')->isUUIDv1('Message is uuid v1');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is uuid v1', $validator->errors()->first('field')?->getMessage());
    }
}
