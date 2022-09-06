<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Scalar as ScalarRule;

class Scalar extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return ScalarRule::NAME;
    }
}
