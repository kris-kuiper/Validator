<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\DivisibleBy as DivisibleByRule;

class DivisibleBy extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DivisibleByRule::NAME;
    }
}
