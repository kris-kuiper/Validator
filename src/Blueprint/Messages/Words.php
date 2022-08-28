<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Words as WordsRule;

class Words extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return WordsRule::NAME;
    }
}
