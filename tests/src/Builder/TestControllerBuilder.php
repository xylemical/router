<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Definition\ControllerInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides a test controller builder.
 */
class TestControllerBuilder extends ControllerBuilderBase {

  /**
   * {@inheritdoc}
   */
  public function build(mixed $controller, array $arguments, RouteInterface $route, BuilderInterface $builder): ?ControllerInterface {
    return NULL;
  }

}
