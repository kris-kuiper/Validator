<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\ContainsDigit as ContainsDigitRule;

class ContainsDigit extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return ContainsDigitRule::NAME;
    }
}
