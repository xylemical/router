<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Definition\ParameterInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides a test parameter builder.
 */
class TestParameterBuilder extends ParameterBuilderBase {

  /**
   * {@inheritdoc}
   */
  public function build(string $segment, array $parameters, RouteInterface $route, BuilderInterface $builder): ?ParameterInterface {
    return NULL;
  }

}
