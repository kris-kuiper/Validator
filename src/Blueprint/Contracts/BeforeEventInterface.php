<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Contracts;

use KrisKuiper\Validator\Blueprint\Events\BeforeEvent;

interface BeforeEventInterface
{
    /**
     * Handler for the before event
     */
    public function handle(BeforeEvent $event): void;
}
