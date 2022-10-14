<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\AlphaSpace as AlphaSpaceRule;

class AlphaSpace extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return AlphaSpaceRule::NAME;
    }
}
