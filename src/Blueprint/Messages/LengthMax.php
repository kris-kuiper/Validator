<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\LengthMax as LengthMaxRule;

class LengthMax extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return LengthMaxRule::NAME;
    }
}
