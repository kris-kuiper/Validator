<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\AlphaDash as AlphaDashRule;

class AlphaDash extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return AlphaDashRule::NAME;
    }
}
