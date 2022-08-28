<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Required as RequiredRule;

class Required extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return RequiredRule::NAME;
    }
}
