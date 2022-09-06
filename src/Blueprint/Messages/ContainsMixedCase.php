<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\ContainsMixedCase as ContainsMixedCaseRule;

class ContainsMixedCase extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return ContainsMixedCaseRule::NAME;
    }
}
