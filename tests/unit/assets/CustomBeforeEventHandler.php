<?php

declare(strict_types=1);

namespace tests\unit\assets;

use KrisKuiper\Validator\Blueprint\Contracts\BeforeEventInterface;
use KrisKuiper\Validator\Blueprint\Events\BeforeEvent;

final class CustomBeforeEventHandler implements BeforeEventInterface
{
    public function handle(BeforeEvent $event): void
    {
        $ids = $event->getValue('product.*.id');
        $event->storage()->set('ids', $ids);
    }
}
