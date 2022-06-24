<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Definition\ControllerInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides the controller builder.
 */
interface ControllerBuilderInterface {

  /**
   * ConstructorBuilderInterface constructor.
   */
  public function __construct();

  /**
   * Get the controller definition.
   *
   * @param mixed $controller
   *   The controller.
   * @param \Xylemical\Router\Definition\ArgumentInterface[] $arguments
   *   The arguments.
   * @param \Xylemical\Router\Definition\RouteInterface $route
   *   The route.
   * @param \Xylemical\Router\Builder\BuilderInterface $builder
   *   The builder.
   *
   * @return \Xylemical\Router\Definition\ControllerInterface|null
   *   The controller or NULL.
   */
  public function build(mixed $controller, array $arguments, RouteInterface $route, BuilderInterface $builder): ?ControllerInterface;

}
