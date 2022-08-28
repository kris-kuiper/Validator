<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IsUUIDv3 as IsUUIDv3Rule;

class IsUUIDv3 extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IsUUIDv3Rule::NAME;
    }
}
