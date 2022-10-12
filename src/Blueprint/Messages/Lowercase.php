<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Lowercase as LowercaseRule;

class Lowercase extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return LowercaseRule::NAME;
    }
}
