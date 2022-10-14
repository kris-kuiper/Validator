<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\WordsMax as WordsMaxRule;

class WordsMax extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return WordsMaxRule::NAME;
    }
}
