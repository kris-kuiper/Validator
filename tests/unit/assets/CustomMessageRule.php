<?php

declare(strict_types=1);

namespace tests\unit\assets;

use KrisKuiper\Validator\Blueprint\Contracts\RuleInterface;
use KrisKuiper\Validator\Blueprint\Custom\Current;

final class CustomMessageRule implements RuleInterface
{
    public const RULE_NAME = 'customMessageRule';

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return self::RULE_NAME;
    }

    /**
     * @inheritdoc
     */
    public function isValid(Current $current): bool
    {
        $current->message('foo bar');
        return false;
    }

    public function getMessage(): string
    {
        return 'Invalid input';
    }
}
