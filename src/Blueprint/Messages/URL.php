<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\URL as URLRule;

class URL extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return URLRule::NAME;
    }
}
