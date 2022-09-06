<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\UUIDv4 as UUIDv4Rule;

class UUIDv4 extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return UUIDv4Rule::NAME;
    }
}
