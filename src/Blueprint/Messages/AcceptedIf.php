<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\AcceptedIf as AcceptedIfRule;

class AcceptedIf extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return AcceptedIfRule::NAME;
    }
}
