<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Contracts;

use KrisKuiper\Validator\Blueprint\Events\AfterEvent;

interface AfterEventInterface
{
    /**
     * Handler for the before event
     */
    public function handle(AfterEvent $event): void;
}
