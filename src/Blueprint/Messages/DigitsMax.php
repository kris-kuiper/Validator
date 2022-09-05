<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\DigitsMax as DigitsMaxRule;

class DigitsMax extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DigitsMaxRule::NAME;
    }
}
