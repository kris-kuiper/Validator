<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\ProhibitedIf as ProhibitedIfRule;

class ProhibitedIf extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return ProhibitedIfRule::NAME;
    }
}
