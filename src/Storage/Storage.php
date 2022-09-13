<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Storage;

class Storage
{
    private array $storage = [];

    public function get(string|int $key): mixed
    {
        return $this->storage[$key] ?? null;
    }

    public function has(string|int $key): bool
    {
        return array_key_exists($key, $this->storage);
    }

    public function set(string|int $key, mixed $value): void
    {
        $this->storage[$key] = $value;
    }
}
