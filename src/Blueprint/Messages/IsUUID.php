<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IsUUID as IsUUIDRule;

class IsUUID extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IsUUIDRule::NAME;
    }
}
