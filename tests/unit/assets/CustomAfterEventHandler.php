<?php

declare(strict_types=1);

namespace tests\unit\assets;

use KrisKuiper\Validator\Blueprint\Contracts\AfterEventInterface;
use KrisKuiper\Validator\Blueprint\Events\AfterEvent;

final class CustomAfterEventHandler implements AfterEventInterface
{
    public function handle(AfterEvent $event): void
    {
        $ids = $event->getValue('product.*.id');
        $event->storage()->set('ids', $ids);
    }
}
