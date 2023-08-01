<?php

namespace Tenko\OceanEngine\Library;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $apps = [];

    private array $configs;

    public function __construct(array $configs) {
        $this->configs = $configs;
    }

    public function get(string $id)
    {
        if (!isset($this->apps[$id])) {
            $this->apps[$id] = new $id($this->configs);
        }

        return $this->apps[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->apps[$id]);
    }
}