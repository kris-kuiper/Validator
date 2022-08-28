<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Min as MinRule;

class Min extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return MinRule::NAME;
    }
}
