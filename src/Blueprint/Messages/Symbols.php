<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\ContainsSymbol as SymbolsRule;

class Symbols extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return SymbolsRule::NAME;
    }
}
