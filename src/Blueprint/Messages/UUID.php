<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\UUID as UUIDRule;

class UUID extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return UUIDRule::NAME;
    }
}
