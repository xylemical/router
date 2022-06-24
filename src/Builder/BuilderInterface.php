<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Definition\ArgumentInterface;
use Xylemical\Router\Definition\ControllerInterface;
use Xylemical\Router\Definition\DefinitionInterface;
use Xylemical\Router\Definition\ParameterInterface;
use Xylemical\Router\Definition\RouteDefinition;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides the builder.
 */
interface BuilderInterface {

  /**
   * Get the definition.
   *
   * @return \Xylemical\Router\Definition\DefinitionInterface
   *   The definition.
   *
   * @throws \Xylemical\Router\Exception\InvalidDefinitionException
   */
  public function getDefinition(): DefinitionInterface;

  /**
   * Get the route definition.
   *
   * @param \Xylemical\Router\Definition\RouteDefinition $route
   *   The route.
   *
   * @return \Xylemical\Router\Definition\RouteInterface|null
   *   The definition or NULL.
   */
  public function getRoute(RouteDefinition $route): ?RouteInterface;

  /**
   * Get the route parameter definition.
   *
   * @param \Xylemical\Router\Definition\RouteInterface $route
   *   The route.
   * @param string $segment
   *   The segments.
   * @param array $parameters
   *   The parameter information.
   *
   * @return \Xylemical\Router\Definition\ParameterInterface|null
   *   The parameter or NULL.
   */
  public function getParameter(RouteInterface $route, string $segment, array $parameters): ?ParameterInterface;

  /**
   * Get the route controller definition.
   *
   * @param \Xylemical\Router\Definition\RouteInterface $route
   *   The route.
   * @param mixed $controller
   *   The controller.
   * @param \Xylemical\Router\Definition\ArgumentInterface[] $arguments
   *   The arguments for the method.
   *
   * @return \Xylemical\Router\Definition\ControllerInterface|null
   *   The controller definition or NULL.
   */
  public function getController(RouteInterface $route, mixed $controller, array $arguments): ?ControllerInterface;

  /**
   * Get the argument definition.
   *
   * @param \Xylemical\Router\Definition\RouteInterface $route
   *   The route.
   * @param mixed $argument
   *   The argument.
   *
   * @return \Xylemical\Router\Definition\ArgumentInterface|null
   *   The argument definition or NULL.
   */
  public function getArgument(RouteInterface $route, mixed $argument): ?ArgumentInterface;

}
