<?php

declare(strict_types=1);

namespace tests\unit\assets;

use KrisKuiper\Validator\Blueprint\Contracts\RuleInterface;
use KrisKuiper\Validator\Blueprint\Events\Event;
use KrisKuiper\Validator\Exceptions\ValidatorException;

final class CustomRule implements RuleInterface
{
    public const RULE_NAME = 'customRule';

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return self::RULE_NAME;
    }

    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function isValid(Event $event): bool
    {
        return strlen($event->getValue()) >= $event->getParameter('min');
    }

    public function getMessage(): string
    {
        return 'Invalid input';
    }
}
