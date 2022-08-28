<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Distinct as DistinctRule;

class Distinct extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DistinctRule::NAME;
    }
}
