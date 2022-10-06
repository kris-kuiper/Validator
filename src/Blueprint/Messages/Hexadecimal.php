<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Hexadecimal as HexadecimalRule;

class Hexadecimal extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return HexadecimalRule::NAME;
    }
}
