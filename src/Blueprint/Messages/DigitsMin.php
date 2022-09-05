<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\DigitsMin as DigitsMinRule;

class DigitsMin extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DigitsMinRule::NAME;
    }
}
