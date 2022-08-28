<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Max as MaxRule;

class Max extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return MaxRule::NAME;
    }
}
