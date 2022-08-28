<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\In as InRule;

class In extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return InRule::NAME;
    }
}
