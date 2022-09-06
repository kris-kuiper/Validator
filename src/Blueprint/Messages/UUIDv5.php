<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\UUIDv5 as UUIDv5Rule;

class UUIDv5 extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return UUIDv5Rule::NAME;
    }
}
