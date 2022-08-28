<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Equals as EqualsRule;

class Equals extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return EqualsRule::NAME;
    }
}
