<?php

declare(strict_types=1);

namespace tests\unit\assets;

use KrisKuiper\Validator\Blueprint\Contracts\RuleInterface;
use KrisKuiper\Validator\Blueprint\Custom\Current;
use KrisKuiper\Validator\Exceptions\ValidatorException;

final class CustomRule implements RuleInterface
{
    public const RULE_NAME = 'CustomRule';

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
    public function isValid(Current $current): bool
    {
        return strlen($current->getValue()) >= $current->getParameter('min');
    }

    public function getMessage(): string
    {
        return 'Invalid input';
    }
}
