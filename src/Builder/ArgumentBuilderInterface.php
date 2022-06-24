<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Definition\ArgumentInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides for building arguments.
 */
interface ArgumentBuilderInterface {

  /**
   * ArgumentBuilderInterface constructor.
   */
  public function __construct();

  /**
   * Get the argument definition.
   *
   * @param mixed $argument
   *   The argument source definition.
   * @param \Xylemical\Router\Definition\RouteInterface $route
   *   The route.
   * @param \Xylemical\Router\Builder\BuilderInterface $builder
   *   The builder.
   *
   * @return \Xylemical\Router\Definition\ArgumentInterface|null
   *   The argument.
   */
  public function build(mixed $argument, RouteInterface $route, BuilderInterface $builder): ?ArgumentInterface;

}
