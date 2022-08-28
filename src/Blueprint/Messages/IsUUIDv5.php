<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IsUUIDv5 as IsUUIDv5Rule;

class IsUUIDv5 extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IsUUIDv5Rule::NAME;
    }
}
