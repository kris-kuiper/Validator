<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Cache;

class Cache
{
    private array $cache = [];

    public function get(string|int $key): mixed
    {
        return $this->cache[$key] ?? null;
    }

    public function has(string|int $key): bool
    {
        return array_key_exists($key, $this->cache);
    }

    public function set(string|int $key, mixed $value): void
    {
        $this->cache[$key] = $value;
    }
}
