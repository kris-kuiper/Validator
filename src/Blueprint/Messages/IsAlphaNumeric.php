<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IsAlphaNumeric as IsAlphaNumericRule;

class IsAlphaNumeric extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IsAlphaNumericRule::NAME;
    }
}
