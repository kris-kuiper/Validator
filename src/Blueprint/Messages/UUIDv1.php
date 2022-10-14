<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\UUIDv1 as UUIDv1Rule;

class UUIDv1 extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return UUIDv1Rule::NAME;
    }
}
