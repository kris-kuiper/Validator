<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Regex as RegexRule;

class Regex extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return RegexRule::NAME;
    }
}
