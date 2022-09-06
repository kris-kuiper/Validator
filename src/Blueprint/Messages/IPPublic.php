<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IPPublic as IPPublicRule;

class IPPublic extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IPPublicRule::NAME;
    }
}
