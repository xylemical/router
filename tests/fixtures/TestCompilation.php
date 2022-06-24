<?php

declare(strict_types=1);

namespace App;

use Xylemical\Router\RouteInterface;
use Xylemical\Router\Router as RouterRouter;


class Router extends RouterRouter {

    protected const PATHS = [
      '' => [
        0 => '`^(?:(*MARK:r1))$`A',
      ],
      'admin' => [
        0 => '`^(?:(*MARK:r2)admin/config|(*MARK:r3)admin/(\w+))$`A',
      ],
      '*' => [
        0 => '`^(?:(*MARK:r4)(\d+)/(\d+)|(*MARK:r6)(.*?)/content)$`A',
      ],
    ];

    protected const METHODS = [
      'r1' => [
        'POST' => 'r1',
      ],
      'r2' => [
        'GET' => 'r2',
        '*' => 'r5',
      ],
    ];

    protected const ROUTES = [
      'r1' => 'getR0',
      'r2' => 'getR1',
      'r3' => 'getR2',
      'r4' => 'getR3',
      'r5' => 'getR4',
      'r6' => 'getR5',
    ];

    public function getR0(string $route_name, array $parameters): RouteInterface {
        $route = new \App\Route($route_name, $parameters);
        $route->setRequest($this->request);
        $route->setController(NULL);
        return $route;

    }

    public function getR1(string $route_name, array $parameters): RouteInterface {
        $route = new \Xylemical\Router\Route($route_name, $parameters);
        $route->setRequest($this->request);
        $route->setController(NULL);
        return $route;

    }

    public function getR2(string $route_name, array $parameters): RouteInterface {
        $parameters = [
          'user' => $parameters[0],
        ];
        $route = new \Xylemical\Router\Route($route_name, $parameters);
        $route->setRequest($this->request);
        $route->setController(NULL);
        return $route;

    }

    public function getR3(string $route_name, array $parameters): RouteInterface {
        $parameters = [
          'id' => $parameters[0],
          'token' => $parameters[1],
        ];
        $route = new \Xylemical\Router\Route($route_name, $parameters);
        $route->setRequest($this->request);
        $route->setController(NULL);
        return $route;

    }

    public function getR4(string $route_name, array $parameters): RouteInterface {
        $route = new \Xylemical\Router\Route($route_name, $parameters);
        $route->setRequest($this->request);
        $route->setController(
          new \App\ControllerDefinition(
            'App\Controller',
            'get',
            []
          )
        );
        return $route;

    }

    public function getR5(string $route_name, array $parameters): RouteInterface {
        $parameters = [
          'type' => $parameters[0],
        ];
        $route = new \Xylemical\Router\Route($route_name, $parameters);
        $route->setRequest($this->request);
        $route->setController(
          new \Xylemical\Router\Controller(
            'App\Controller',
            'get',
            [
              $this->get('App\Service'),
              1,
              getenv('OMG') !== FALSE ? getenv('OMG') : 'FOO',
            ]
          )
        );
        return $route;

    }

}
