<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\AfterOrEqual as AfterOrEqualRule;

class AfterOrEqual extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return AfterOrEqualRule::NAME;
    }
}
