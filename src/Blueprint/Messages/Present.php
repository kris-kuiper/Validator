<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Present as PresentRule;

class Present extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return PresentRule::NAME;
    }
}
