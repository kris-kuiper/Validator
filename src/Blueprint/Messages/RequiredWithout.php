<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\RequiredWithout as RequiredWithoutRule;

class RequiredWithout extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return RequiredWithoutRule::NAME;
    }
}
