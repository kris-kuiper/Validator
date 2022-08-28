<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\MinWords as MinWordsRule;

class MinWords extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return MinWordsRule::NAME;
    }
}
