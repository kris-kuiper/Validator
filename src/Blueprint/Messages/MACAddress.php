<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\MACAddress as MACAddressRule;

class MACAddress extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return MACAddressRule::NAME;
    }
}
