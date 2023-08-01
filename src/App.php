<?php

namespace Tenko\OceanEngine;

use Psr\Container\ContainerInterface;
use Tenko\OceanEngine\Client\OAuth;
use Tenko\OceanEngine\Client\Request;
use Tenko\OceanEngine\Library\Container;

/**
 * @property-read OAuth $OAuth
 * @property-read Request $Request
 */
class App
{
    private ContainerInterface $container;

    public function __construct(array $config) {
        $this->container = new Container($config);
    }

    public function __get(string $name) {
        $class = '\\Tenko\\OceanEngine\\Client\\' . $name;

        if (class_exists($class)) {
            return $this->container->get($class);
        }

        throw new \Exception('could not found this client');
    }
}