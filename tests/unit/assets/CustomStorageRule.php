<?php

declare(strict_types=1);

namespace tests\unit\assets;

use KrisKuiper\Validator\Blueprint\Contracts\RuleInterface;
use KrisKuiper\Validator\Blueprint\Custom\Current;

final class CustomStorageRule implements RuleInterface
{
    public const RULE_NAME = 'customStorageRule';

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
        $current->storage()->set('quez', 'bazz');

        if (true === $current->storage()->has('foo')) {
            return 'bar' === $current->storage()->get('foo');
        }

        return false;
    }

    public function getMessage(): string
    {
        return 'Invalid input';
    }
}
