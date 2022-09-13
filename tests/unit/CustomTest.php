<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Blueprint\Custom\Current;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Validator;
use PHPUnit\Framework\TestCase;
use tests\unit\assets\CustomRule;

final class CustomTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfCustomRuleCanBeLoadedWhenCallingTheCustomMethod(): void
    {
        $data = [
            'name' => 'Morris',
            'likes' => ['dogs', 'cats']
        ];

        $validator = new Validator($data);
        $parameters = ['min' => 10];
        $ruleName = 'length';

        $validator->custom($ruleName, function (Current $validator) use ($data, $parameters, $ruleName) {

            $this->assertEquals($data['name'], $validator->getValue());
            $this->assertEquals($parameters, $validator->getParameters());
            $this->assertEquals('name', $validator->getFieldName());
            $this->assertEquals($data, $validator->getValidationData());
            $this->assertEquals(10, $validator->getParameter('min'));
            $this->assertEquals($ruleName, $validator->getRuleName());

            return strlen($validator->getValue()) > $validator->getParameter('min');
        });

        $validator->messages('name')->custom('length', 'Invalid value, at least :min characters');
        $validator->field('name')->custom($ruleName, $parameters);

        $this->assertFalse($validator->execute());
        $this->assertSame('Invalid value, at least :min characters', $validator->errors()->first('name')->getRawMessage());
        $this->assertSame('Invalid value, at least 10 characters', $validator->errors()->first('name')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCacheIsCorrectWhenSettingCacheInsideCustomRule(): void
    {
        $data = [
            'name' => 'Morris',
            'likes' => ['dogs', 'cats']
        ];

        $validator = new Validator($data);
        $ruleName = 'length';

        $validator->custom($ruleName, function (Current $validator) {

            $this->assertFalse($validator->cache()->has('foo'));
            $this->assertNull($validator->cache()->get('foo'));
            $validator->cache()->set('foo', 'bar');
            $this->assertTrue($validator->cache()->has('foo'));
            $this->assertSame('bar', $validator->cache()->get('foo'));
            return false;
        });

        $validator->field('name')->custom($ruleName);

        $this->assertFalse($validator->cache()->has('foo'));
        $this->assertNull($validator->cache()->get('foo'));
        $this->assertFalse($validator->execute());
        $this->assertTrue($validator->cache()->has('foo'));
        $this->assertSame('bar', $validator->cache()->get('foo'));
    }

    /**
     * @throws ValidatorException
     */
    public function testIfMultipleCustomRulesCanBeExecutedWhenProvidedMultipleCustomRules(): void
    {
        $executed = 0;
        $validator = new Validator(['foo' => 25]);

        $custom = static function () use (&$executed) {

            $executed++;
            return true;
        };

        $validator->custom('custom1', $custom);
        $validator->custom('custom2', $custom);
        $validator->field('foo')->custom('custom1')->custom('custom2');

        $this->assertTrue($validator->execute());
        $this->assertSame(2, $executed);
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomRulePassesWhenProvidingParameters(): void
    {
        $validator = new Validator([
            'name' => 'Morris'
        ]);

        $validator->loadRule(new CustomRule());
        $validator->field('name')->custom(CustomRule::RULE_NAME, ['min' => 20]);

        $this->assertFalse($validator->execute());
        $this->assertSame('Invalid input', $validator->errors()->first('name')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomRuleReturnsCorrectMessageWhenProvidingCustomMessage(): void
    {
        $validator = new Validator([
            'name' => 'Morris'
        ]);

        $validator->loadRule(new CustomRule());
        $validator->field('name')->custom(CustomRule::RULE_NAME, ['min' => 20]);
        $validator->messages()->custom(CustomRule::RULE_NAME, 'foobar');

        $this->assertFalse($validator->execute());
        $this->assertSame('foobar', $validator->errors()->first('name')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomRuleReturnsCorrectMessageWhenProvidingCustomMessageAndField(): void
    {
        $validator = new Validator([
            'name' => 'Morris'
        ]);

        $validator->loadRule(new CustomRule());
        $validator->field('name')->custom(CustomRule::RULE_NAME, ['min' => 20]);
        $validator->messages('name')->custom(CustomRule::RULE_NAME, 'foobar');

        $this->assertFalse($validator->execute());
        $this->assertSame('foobar', $validator->errors()->first('name')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomRuleValidationReturnCorrectErrorMessageWhenSettingNewErrorMessage(): void
    {
        $validator = new Validator([
            'name' => 'Morris'
        ]);

        $validator->loadRule(new CustomRule());
        $validator->field('name')->custom('CustomRule', ['min' => 20]);
        $validator->messages('name')->custom('CustomRule', 'foobar');

        $this->assertFalse($validator->execute());
        $this->assertSame('foobar', $validator->errors()->first('name')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfExceptionIsThrownWhenWrongCustomRuleNameIsProvided(): void
    {
        $this->expectException(ValidatorException::class);

        $validator = new Validator([
            'name' => 'Morris'
        ]);

        $validator->loadRule(new CustomRule());
        $validator->field('name')->custom('foo');
        $validator->execute();
    }

    /**
     * @throws ValidatorException
     */
    public function testIfExceptionIsThrownWhenCallbackIsNotSet(): void
    {
        $this->expectException(ValidatorException::class);

        $validator = new Validator([
            'name' => 'Morris'
        ]);

        $validator->loadRule(new CustomRule());
        $validator->field('name')->custom('foo');
        $validator->execute();
    }
}
