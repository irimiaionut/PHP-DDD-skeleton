<?php

namespace App\Infrastructure\Controllers;

use App\Application\ControllerServices\TestService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TestController {
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function test(Request $request, Response $response, $args)
    {

        $testService = $this->container->get(TestService::class);
        $message = $testService->test();

        $payload = json_encode($message);

        $response->getBody()->write($payload);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }


}