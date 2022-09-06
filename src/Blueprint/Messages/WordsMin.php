<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\WordsMin as WordsMinRule;

class WordsMin extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return WordsMinRule::NAME;
    }
}
