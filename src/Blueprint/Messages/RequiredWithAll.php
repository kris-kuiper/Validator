<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\RequiredWithAll as RequiredWithAllRule;

class RequiredWithAll extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return RequiredWithAllRule::NAME;
    }
}
