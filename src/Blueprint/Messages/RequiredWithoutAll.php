<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\RequiredWithoutAll as RequiredWithoutAllRule;

class RequiredWithoutAll extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return RequiredWithoutAllRule::NAME;
    }
}
