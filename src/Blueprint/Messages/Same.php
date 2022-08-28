<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Same as SameRule;

class Same extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return SameRule::NAME;
    }
}
