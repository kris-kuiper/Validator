<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\CSSColor as CSSColorRule;

class CSSColor extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return CSSColorRule::NAME;
    }
}
