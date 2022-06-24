<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder\Argument;

use Xylemical\Router\Builder\ArgumentBuilderBase;
use Xylemical\Router\Builder\BuilderInterface;
use Xylemical\Router\Definition\Argument;
use Xylemical\Router\Definition\ArgumentInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides a generic argument builder.
 */
class GenericArgumentBuilder extends ArgumentBuilderBase {

  /**
   * {@inheritdoc}
   */
  public function build(mixed $argument, RouteInterface $route, BuilderInterface $builder): ?ArgumentInterface {
    return new Argument($argument);
  }

}
