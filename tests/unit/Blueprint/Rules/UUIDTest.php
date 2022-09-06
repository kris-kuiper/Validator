<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class UUIDTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyUUIDv1ValuesAreProvided(): void
    {
        $uuids = [
            '95fa2bd2-fbdc-11ec-b939-0242ac120002',
            'ab2bfa26-fbdc-11ec-b939-0242ac120002',
            'ab2bdb04-fbdc-11ec-b939-0242ac120002',
            'ed7907b5-d843-3370-b0bc-8f77b5f0f446',
            '2c5ec513-a997-3d10-a751-d21c5ad14784',
            '93b7f04d-22e6-32e2-82d3-a1a2c4163743',
            '391a48a1-d92d-45a6-9235-9ca939c3554a',
            '40a0e2de-7051-410d-b2a0-6aa272f31297',
            '0588f70c-0687-46b4-a5f2-bbeca69b5f32',
            '6fad3a7b-161b-5e10-b265-8d522f3f35b5',
            '425cb93b-2a12-5d90-85be-3b75601c409a',
            '8c7a80eb-27dc-5fc2-b8fb-9c5ee63b462e',
        ];

        foreach ($uuids as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->uuid();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonUUIDv1ValuesAreProvided(): void
    {
        foreach ([null, (object) [], 2552, 1, 0, '2817334', 'abcd123', 'zb2bfa26-fbdc-11ec-b939-0242ac120002', 'ab2bfa26-fbdc-11ec-b939-0g42ac120002'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->uuid();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->uuid();
        $validator->messages('field')->uuid('Message is uuid');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is uuid', $validator->errors()->first('field')?->getMessage());
    }
}
