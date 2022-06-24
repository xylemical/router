<?php

declare(strict_types=1);

namespace Xylemical\Router;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use function preg_match;

/**
 * Provides the base router for execution.
 */
class Router implements RouterInterface {

  /**
   * The path mappings to settle the routing.
   */
  protected const PATHS = [];

  /**
   * The method mappings.
   */
  protected const METHODS = [];

  /**
   * The route creation callables.
   */
  protected const ROUTES = [];

  /**
   * The container.
   *
   * @var \Psr\Container\ContainerInterface
   */
  protected ContainerInterface $container;

  /**
   * The raw path.
   *
   * @var string
   */
  protected string $path;

  /**
   * The request.
   *
   * @var \Psr\Http\Message\ServerRequestInterface
   */
  protected ServerRequestInterface $request;

  /**
   * Router constructor.
   *
   * @param \Psr\Container\ContainerInterface $container
   *   The container used for dependency injection.
   */
  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }

  /**
   * {@inheritdoc}
   */
  public function match(ServerRequestInterface $request): ?RouteInterface {
    $this->path = $request->getRequestTarget();
    $this->request = $request;

    if (!($route = $this->getRoute())) {
      return NULL;
    }

    $route_name = $this->getRouteMethod($route['MARK'], $request->getMethod());
    if (!$route_name) {
      return NULL;
    }

    $parameters = array_slice(array_filter($route), 1, -1);

    return call_user_func_array(
      [$this, static::ROUTES[$route_name]],
      [$route_name, $parameters],
    );
  }

  /**
   * Get the service for dependency injection.
   *
   * @param string $service
   *   The service.
   *
   * @return mixed
   *   The service.
   *
   * @throws \Psr\Container\ContainerExceptionInterface
   * @throws \Psr\Container\NotFoundExceptionInterface
   */
  protected function get(string $service): mixed {
    if ($this->container->has($service)) {
      return $this->container->get($service);
    }
    return NULL;
  }

  /**
   * Get the route match.
   *
   * @return array|null
   *   The regex match or NULL.
   */
  protected function getRoute(): ?array {
    $path = trim($this->path, '/');
    $segments = explode('/', $path);
    $segment = reset($segments) ?: '';
    if (isset(static::PATHS[$segment])) {
      foreach (static::PATHS[$segment] as $pattern) {
        if (preg_match($pattern, $path, $match)) {
          return $match;
        }
      }
    }
    if (isset(static::PATHS['*'])) {
      foreach (static::PATHS['*'] as $pattern) {
        if (preg_match($pattern, $path, $match)) {
          return $match;
        }
      }
    }
    return NULL;
  }

  /**
   * Get route by method.
   *
   * @param string $route
   *   The route.
   * @param string $method
   *   The method.
   *
   * @return string|null
   *   The route or NULL.
   */
  protected function getRouteMethod(string $route, string $method): ?string {
    if (isset(static::METHODS[$route])) {
      if (isset(static::METHODS[$route][$method])) {
        return static::METHODS[$route][$method];
      }
      elseif (isset(static::METHODS[$route]['*'])) {
        return static::METHODS[$route]['*'];
      }
      return NULL;
    }
    return $route;
  }

}
