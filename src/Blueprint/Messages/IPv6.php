<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IPv6 as IPv6Rule;

class IPv6 extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IPv6Rule::NAME;
    }
}
