<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\SameNot as SameNotRule;

class SameNot extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return SameNotRule::NAME;
    }
}
