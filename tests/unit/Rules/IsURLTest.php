<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsURLTest extends TestCase
{
    private array $urls;
    private array $urlsProtocol;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->urls = require('./tests/unit/assets' . DIRECTORY_SEPARATOR . 'http-urls.php');
        $this->urlsProtocol = require('./tests/unit/assets' . DIRECTORY_SEPARATOR . 'urls.php');
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenURLValuesAreProvided(): void
    {
        foreach ($this->urls as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isURL();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenURLWithProtocolValuesAreProvided(): void
    {
        foreach ($this->urlsProtocol as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isURL();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenURLValuesAreProvidedButProtocolIsRequired(): void
    {
        foreach ($this->urls as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isURL(true);
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonURLValuesAreProvided(): void
    {
        foreach ([null, (object) [], 2552, 1, 0, '2817334', 'abcd123'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isUrl();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomErrorMessageCanBeSetWhenValidationFails(): void
    {
        $validator = new Validator(['field' => []]);
        $validator->field('field')->isUrl();
        $validator->messages('field')->isUrl('Message is url');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message is url', $validator->errors()->first('field')?->getMessage());
    }
}
