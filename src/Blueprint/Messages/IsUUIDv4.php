<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IsUUIDv4 as IsUUIDv4Rule;

class IsUUIDv4 extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IsUUIDv4Rule::NAME;
    }
}
