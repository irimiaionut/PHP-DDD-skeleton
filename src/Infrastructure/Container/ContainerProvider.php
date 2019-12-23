<?php

namespace App\Infrastructure\Container;

use DI\Container;

class ContainerProvider
{
    private $container = null;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function getContainer()
    {
        return $this->container;
    }

}