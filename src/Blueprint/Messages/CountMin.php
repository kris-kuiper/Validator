<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\CountMin as CountMinRule;

class CountMin extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return CountMinRule::NAME;
    }
}
