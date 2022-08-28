<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\NotIn as NotInRule;

class NotIn extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return NotInRule::NAME;
    }
}
