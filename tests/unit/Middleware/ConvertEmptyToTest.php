<?php

declare(strict_types=1);

namespace tests\unit\Middleware;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class ConvertEmptyToTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenUsingSimpleFieldValue222(): void
    {
        $data = ['field' => ''];

        $validator = new Validator($data);
        $validator->middleware('field')->convertEmptyTo();
        $validator->field('field')->equals(null);

        $this->assertTrue($validator->execute());
    }
}
