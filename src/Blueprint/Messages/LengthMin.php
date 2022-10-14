<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\LengthMin as LengthMinRule;

class LengthMin extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return LengthMinRule::NAME;
    }
}
