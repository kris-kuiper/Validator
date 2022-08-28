<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\ContainsMixedCase as MixedCaseRule;

class MixedCase extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return MixedCaseRule::NAME;
    }
}
