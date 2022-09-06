<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\ContainsSymbol as ContainsSymbolRule;

class ContainsSymbol extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return ContainsSymbolRule::NAME;
    }
}
