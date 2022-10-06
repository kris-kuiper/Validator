<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class CSSColorTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenValidValuesAreProvided(): void
    {
        foreach (['ffffff', 'FFFFFF', 'FFF', '#ffffff', '#FFFFFF', '#fff', 'fFf', 'fFfFfF', '#fFfFfF', '012345', '6789ab', 'cdefAB', 'CDEF00'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->cssColor();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenHashSignIsRequiredButNotProvided(): void
    {
        foreach (['ffffff', 'FFFFFF', 'FFF', 'fFf', 'fFfFfF', '012345', '6789ab', 'cdefAB', 'CDEF00'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->cssColor(true);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenShortcodesAreDisabled(): void
    {
        foreach (['FFF', '#fff', 'fFf'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->cssColor(false, false);
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonValidValuesAreProvided(): void
    {
        foreach ([(object) [], ' ', true, false, '', -2.5, '-1', -0.1, '-0.1', [], 'g', '01234z', '01234Z'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->cssColor();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->cssColor();
        $validator->messages('field')->cssColor('Message is css color');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is css color', $validator->errors()->first('field')?->getMessage());
    }
}
