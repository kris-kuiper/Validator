<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\ContainsNot as ContainsNotRule;

class ContainsNot extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return ContainsNotRule::NAME;
    }
}
