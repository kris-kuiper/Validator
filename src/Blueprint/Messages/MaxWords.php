<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\MaxWords as MaxWordsRule;

class MaxWords extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return MaxWordsRule::NAME;
    }
}
