<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Definition\ArgumentInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides a test argument builder.
 */
class TestArgumentBuilder extends ArgumentBuilderBase {

  /**
   * {@inheritdoc}
   */
  public function build(mixed $argument, RouteInterface $route, BuilderInterface $builder): ?ArgumentInterface {
    return NULL;
  }

}
