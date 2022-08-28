<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\CountMax as CountMaxRule;

class CountMax extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return CountMaxRule::NAME;
    }
}
