<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder\Argument;

use Xylemical\Router\Builder\ArgumentBuilderBase;
use Xylemical\Router\Builder\BuilderInterface;
use Xylemical\Router\Definition\Argument\ServiceArgument;
use Xylemical\Router\Definition\ArgumentInterface;
use Xylemical\Router\Definition\RouteInterface;
use function str_starts_with;

/**
 * Provides a service argument builder.
 */
class ServiceArgumentBuilder extends ArgumentBuilderBase {

  /**
   * {@inheritdoc}
   */
  public function build(mixed $argument, RouteInterface $route, BuilderInterface $builder): ?ArgumentInterface {
    if (is_string($argument) && str_starts_with($argument, '@')) {
      return new ServiceArgument(substr($argument, 1));
    }
    return NULL;
  }

}
