<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Uppercase as UppercaseRule;

class Uppercase extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return UppercaseRule::NAME;
    }
}
