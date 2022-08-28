<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IsUUIDv1 as IsUUIDv1Rule;

class IsUUIDv1 extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IsUUIDv1Rule::NAME;
    }
}
