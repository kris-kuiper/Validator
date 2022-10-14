<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\RequiredArrayKeys as RequiredArrayKeysRule;

class RequiredArrayKeys extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return RequiredArrayKeysRule::NAME;
    }
}
