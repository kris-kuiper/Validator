<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Email as EmailRule;

class Email extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return EmailRule::NAME;
    }
}
