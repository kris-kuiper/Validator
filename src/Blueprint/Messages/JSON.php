<?php
declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\JSON as JSONRule;

class JSON extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return JSONRule::NAME;
    }
}