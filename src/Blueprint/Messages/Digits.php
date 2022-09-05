<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Digits as DigitsRule;

class Digits extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DigitsRule::NAME;
    }
}
