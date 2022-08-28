<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\DifferentWithAll as DifferentWithAllRule;

class DifferentWithAll extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DifferentWithAllRule::NAME;
    }
}
