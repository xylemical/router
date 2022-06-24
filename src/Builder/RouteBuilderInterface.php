<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Definition\RouteDefinition;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides the route builder.
 */
interface RouteBuilderInterface {

  /**
   * RouteBuilderInterface constructor.
   */
  public function __construct();

  /**
   * Get the route.
   *
   * @param \Xylemical\Router\Definition\RouteDefinition $route
   *   The route.
   * @param \Xylemical\Router\Builder\BuilderInterface $builder
   *   The builder.
   *
   * @return \Xylemical\Router\Definition\RouteInterface|null
   *   The route or NULL.
   */
  public function build(RouteDefinition $route, BuilderInterface $builder): ?RouteInterface;

}
