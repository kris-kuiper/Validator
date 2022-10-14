<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class UUIDv3Test extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyUUIDv3ValuesAreProvided(): void
    {
        foreach (['ed7907b5-d843-3370-b0bc-8f77b5f0f446', '2c5ec513-a997-3d10-a751-d21c5ad14784', '93b7f04d-22e6-32e2-82d3-a1a2c4163743'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->uuidv3();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonUUIDv3ValuesAreProvided(): void
    {
        foreach ([null, (object) [], 2552, 1, 0, '2817334', 'abcd123', '95fa2bd2-fbdc-11ec-b939-0242ac120002', '391a48a1-d92d-45a6-9235-9ca939c3554a', '6fad3a7b-161b-5e10-b265-8d522f3f35b5'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->uuidv3();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->uuidv3();
        $validator->messages('field')->uuidv3('Message is uuid v3');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is uuid v3', $validator->errors()->first('field')?->getMessage());
    }
}
