<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Alpha as AlphaRule;

class Alpha extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return AlphaRule::NAME;
    }
}
