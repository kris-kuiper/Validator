<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\UUIDv3 as UUIDv3Rule;

class UUIDv3 extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return UUIDv3Rule::NAME;
    }
}
