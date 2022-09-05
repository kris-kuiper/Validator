<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\BeforeOrEqual as BeforeOrEqualRule;

class BeforeOrEqual extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return BeforeOrEqualRule::NAME;
    }
}
