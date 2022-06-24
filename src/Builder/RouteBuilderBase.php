<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Definition\ControllerInterface;
use Xylemical\Router\Definition\Route;
use Xylemical\Router\Definition\RouteDefinition;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides a base route builder.
 */
abstract class RouteBuilderBase implements RouteBuilderInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct() {
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteDefinition $route, BuilderInterface $builder): ?RouteInterface {
    $result = $this->doRoute($route);
    $this->doParameters($route->getParameters(), $result, $builder);
    $result->setController(
      $this->doController(
        $route->getController(),
        $route->getArguments(),
        $result,
        $builder
      )
    );
    return $result;
  }

  /**
   * Create the route.
   *
   * @param \Xylemical\Router\Definition\RouteDefinition $definition
   *   The route definition.
   *
   * @return \Xylemical\Router\Definition\RouteInterface
   *   The route.
   */
  protected function doRoute(RouteDefinition $definition): RouteInterface {
    $route = new Route($definition->getName(), $definition->getPath());
    $route->setClass($definition->getClass());
    foreach ($definition->getMethods() as $method) {
      $route->addMethod($method);
    }
    return $route;
  }

  /**
   * Process the parameters.
   *
   * @param array $parameters
   *   The parameter definitions.
   * @param \Xylemical\Router\Definition\RouteInterface $route
   *   The route.
   * @param \Xylemical\Router\Builder\BuilderInterface $builder
   *   The builder.
   */
  protected function doParameters(array $parameters, RouteInterface $route, BuilderInterface $builder): void {
    foreach ($route->getPath()->getSegments() as $segment) {
      if ($parameter = $builder->getParameter($route, $segment->getValue(), $parameters)) {
        $segment->setParameter($parameter);
      }
    }
  }

  /**
   * Process the arguments.
   *
   * @param array $arguments
   *   The arguments.
   * @param \Xylemical\Router\Definition\RouteInterface $route
   *   The route.
   * @param \Xylemical\Router\Builder\BuilderInterface $builder
   *   The builder.
   *
   * @return \Xylemical\Router\Definition\ArgumentInterface[]
   *   The arguments.
   */
  protected function doArguments(array $arguments, RouteInterface $route, BuilderInterface $builder): array {
    $results = [];
    foreach ($arguments as $argument) {
      $results[] = $builder->getArgument($route, $argument);
    }
    return $results;
  }

  /**
   * Process the controller.
   *
   * @param mixed $controller
   *   The controller.
   * @param array $arguments
   *   The arguments.
   * @param \Xylemical\Router\Definition\RouteInterface $route
   *   The route.
   * @param \Xylemical\Router\Builder\BuilderInterface $builder
   *   The builder.
   *
   * @return \Xylemical\Router\Definition\ControllerInterface|null
   *   The controller or NULL.
   */
  protected function doController(mixed $controller, array $arguments, RouteInterface $route, BuilderInterface $builder): ?ControllerInterface {
    $arguments = $this->doArguments($arguments, $route, $builder);
    return $builder->getController($route, $controller, $arguments);
  }

}
