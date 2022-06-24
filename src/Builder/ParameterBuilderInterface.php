<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Definition\ParameterInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides a parameter builder.
 */
interface ParameterBuilderInterface {

  /**
   * ParameterBuilderInterface constructor.
   */
  public function __construct();

  /**
   * Get the parameter definition.
   *
   * @param string $segment
   *   The path segment.
   * @param array $parameters
   *   The parameter definition.
   * @param \Xylemical\Router\Definition\RouteInterface $route
   *   The route.
   * @param \Xylemical\Router\Builder\BuilderInterface $builder
   *   The parameter builder.
   *
   * @return \Xylemical\Router\Definition\ParameterInterface|null
   *   The parameter.
   */
  public function build(string $segment, array $parameters, RouteInterface $route, BuilderInterface $builder): ?ParameterInterface;

}
