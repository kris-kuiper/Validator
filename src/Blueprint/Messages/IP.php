<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IP as IPRule;

class IP extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IPRule::NAME;
    }
}
