<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Different as DifferentRule;

class Different extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DifferentRule::NAME;
    }
}
