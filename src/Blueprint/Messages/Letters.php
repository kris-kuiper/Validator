<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\ContainsLetter as LettersRule;

class Letters extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return LettersRule::NAME;
    }
}
