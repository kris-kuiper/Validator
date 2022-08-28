<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\After as AfterRule;

class After extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return AfterRule::NAME;
    }
}
