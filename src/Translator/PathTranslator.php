<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Translator;

use KrisKuiper\Validator\Collections\PathCollection;

class PathTranslator extends AbstractTranslator
{
    /**
     * @inheritdoc
     */
    public function add(string|int|float $key, $value = null): void
    {
        $keys = explode('.', $key);
        $last = array_pop($keys);

        foreach ($keys as $index) {
            if (false === array_key_exists($index, $this->data) || (true === array_key_exists($index, $this->data) && false === is_array($this->data[$index]))) {
                $this->data[$index] = [];
            }

            $this->data = &$this->data[$index];
        }

        if (false === isset($this->data[$last]) || false === is_array($this->data[$last])) {
            $this->data[$last] = $value;
        } else {
            $this->data[$last][] = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function set(string|int|float|array $key, $value = null): void
    {
        if (true === is_array($key)) {
            $this->data = array_replace_recursive($this->data, $key);
        } else {
            $this->remove($key);
            $this->add($key, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function has(string|int|float $key): bool
    {
        $pathCollection = new PathCollection();
        return $this->paths(explode('.', $key), $this->data, $pathCollection, [])->count() > 0;
    }

    /**
     * @inheritdoc
     */
    public function remove(string|int|float $key): void
    {
        $pathCollection = new PathCollection();

        $output = $this->paths(explode('.', $key), $this->data, $pathCollection, []);

        /** @var Path $item */
        foreach ($output as $item) {
            $this->removeFromKeys($item->getPath(), $this->data);
        }
    }

    /**
     * @inheritdoc
     */
    public function get(string|int|float $key): array
    {
        return $this->path($key)->getValues();
    }

    /**
     * Searches the given data array for values based on a string path returns these values with the corresponding paths
     */
    public function path(string|int|float $key): PathCollection
    {
        $pathCollection = new PathCollection();

        if (true === is_numeric($key)) {
            return $this->paths([$key], $this->data, $pathCollection, []);
        }

        return $this->paths(explode('.', (string) $key), $this->data, $pathCollection, []);
    }

    /**
     * Remove keys and values form an associative array by giving a flat key structure as array
     * @param array $keys A flat key array structure
     */
    public function removeFromKeys(array $keys, array &$data): mixed
    {
        $current = array_shift($keys);
        $end = 0 === count($keys);

        if (true === $end) {
            unset($data[$current]);
        }

        if (false === isset($data[$current])) {
            return null;
        }

        return $this->removeFromKeys($keys, $data[$current]);
    }


    /**
     * Searches the given data array for values based on a flat key array and returns these values with the corresponding paths
     * @param array $match A flat key array structure
     */
    private function paths(array $match, $data, PathCollection $pathCollection, $path = []): PathCollection
    {
        $current = array_shift($match);
        $end = 0 === count($match);

        if ('*' === $current) {
            if (true === $end) {
                if (false === is_array($data)) {
                    return $pathCollection;
                }

                foreach ($data as $key => $value) {
                    $tmp = $path;
                    $path[] = $key;
                    $pathCollection->append(new Path($path, $value));
                    $path = $tmp;
                }

                return $pathCollection;
            }

            foreach ($data as $key => $value) {
                if (false === is_array($value)) {
                    continue;
                }

                $tmp = $path;
                $path[] = $key;
                $result = $this->paths($match, $value, $pathCollection, $path);

                if (0 === $result->count()) {
                    array_pop($path);
                    continue;
                }

                $path = $tmp;
            }

            return $pathCollection;
        }

        if (false === array_key_exists($current, $data)) {
            return $pathCollection;
        }

        $path[] = $current;

        if (true === $end) {
            $pathCollection->append(new Path($path, $data[$current]));
            return $pathCollection;
        }

        return $this->paths($match, $data[$current], $pathCollection, $path);
    }
}
