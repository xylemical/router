<?php

declare(strict_types=1);

namespace Xylemical\Router;

/**
 * Provides the router to test behaviour.
 */
class TestRouter extends Router {

  /**
   * Demo routes.
   */
  protected const PATHS = [
    '' => [
      '`^(?:(*MARK:r1))$`A',
    ],
    'admin' => [
      '`^(?:(*MARK:r2)admin/config|(*MARK:r3)admin/(\w+))$`A',
    ],
    '*' => [
      '`^(?:(*MARK:r4)(\d+)/(\d+)|(*MARK:r6)(.*?)/content)$`A',
    ],
  ];

  /**
   * Demo routes sharing methods.
   */
  protected const METHODS = [
    'r1' => ['POST' => 'r1'],
    'r2' => ['GET' => 'r2', '*' => 'r5'],
  ];

  /**
   * Demo route functionality.
   */
  protected const ROUTES = [
    'r1' => 'doRequest',
    'r2' => 'doRequest',
    'r3' => 'doRequest',
    'r4' => 'doRequest',
    'r5' => 'doRequest',
    'r6' => 'doRequest',
  ];

  /**
   * Create routes based on request.
   *
   * @param string $route_name
   *   The route name.
   * @param array $parameters
   *   The parameters.
   *
   * @return \Xylemical\Router\RouteInterface
   *   The route.
   */
  protected function doRequest(string $route_name, array $parameters): RouteInterface {
    $route = new Route($route_name, $parameters);
    $route->setRequest($this->request);
    $route->setController(
      new Controller($this->get('controller'), $this->get('method') ?: '', []),
    );
    return $route;
  }

}
