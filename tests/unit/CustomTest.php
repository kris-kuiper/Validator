<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Blueprint\Events\Event;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Validator;
use PHPUnit\Framework\TestCase;
use tests\unit\assets\CustomMessageRule;
use tests\unit\assets\CustomRule;
use tests\unit\assets\CustomStorageRule;

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

        $validator->custom($ruleName, function (Event $event) use ($data, $parameters, $ruleName) {

            $this->assertEquals($data['name'], $event->getValue());
            $this->assertEquals($parameters, $event->getParameters());
            $this->assertEquals('name', $event->getFieldName());
            $this->assertEquals($data, $event->getValidationData());
            $this->assertEquals(10, $event->getParameter('min'));
            $this->assertEquals($ruleName, $event->getRuleName());

            return strlen($event->getValue()) > $event->getParameter('min');
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

        $validator->custom($ruleName, function (Event $event) {

            $this->assertFalse($event->storage()->has('foo'));
            $this->assertNull($event->storage()->get('foo'));
            $event->storage()->set('foo', 'bar');
            $this->assertTrue($event->storage()->has('foo'));
            $this->assertSame('bar', $event->storage()->get('foo'));
            return false;
        });

        $validator->field('name')->custom($ruleName);

        $this->assertFalse($validator->storage()->has('foo'));
        $this->assertNull($validator->storage()->get('foo'));
        $this->assertFalse($validator->execute());
        $this->assertTrue($validator->storage()->has('foo'));
        $this->assertSame('bar', $validator->storage()->get('foo'));
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
    public function testIfCustomRuleCanRetrieveAndSetValidationStorageWhenSettingStorageOutsideCustomRule(): void
    {
        $validator = new Validator([
            'name' => 'Morris'
        ]);

        $validator->loadRule(new CustomStorageRule());
        $validator->storage()->set('foo', 'bar');
        $validator->field('name')->custom(CustomStorageRule::RULE_NAME);

        $this->assertTrue($validator->execute());
        $this->assertSame('bazz', $validator->storage()->get('quez'));
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

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenSettingMessageInCustomMethod(): void
    {
        $data = [
            'name' => 'Morris',
            'likes' => ['dogs', 'cats']
        ];

        $validator = new Validator($data);
        $parameters = ['min' => 10];
        $ruleName = 'length';

        $validator->custom($ruleName, function (Event $event): bool {

            $event->message('foo :min');
            return false;
        });

        $validator->messages('name')->custom('length', 'foo');
        $validator->field('name')->custom($ruleName, $parameters);

        $this->assertFalse($validator->execute());
        $this->assertSame('foo :min', $validator->errors()->first('name')->getRawMessage());
        $this->assertSame('foo 10', $validator->errors()->first('name')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenSettingMessageInCustomRule(): void
    {
        $validator = new Validator([
            'name' => 'Morris'
        ]);

        $validator->loadRule(new CustomMessageRule());
        $validator->field('name')->custom(CustomMessageRule::RULE_NAME);

        $this->assertFalse($validator->execute());
        $this->assertSame('foo bar', $validator->errors()->first('name')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomValidationCanBeExecutedWhenUsingACustomRule(): void
    {
        $data = ['amount' => 10, 'notes' => 'foo'];

        $validator = new Validator($data);
        $validator->custom('amount', function (Event $event) {
            return $event->getValue() >= 10 && $event->field('notes')->required()->lengthMin(10)->isValid();
        });

        $validator->field('amount')->custom('amount');

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfFilterReturnsCorrectAmountWhenUsingCustomRule(): void
    {
        $data = ['product' => [1, 2, 3]];

        $validator = new Validator($data);
        $validator->custom('product', function (Event $event) use ($data) {
            return count($data['product']) === count($event->filter('product.*')->isInt()->max(3)->toArray());
        });

        $validator->field('product')->custom('product');
        $this->assertTrue($validator->execute());
    }
}
