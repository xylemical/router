<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder\Argument;

use Xylemical\Router\Builder\ArgumentBuilderBase;
use Xylemical\Router\Builder\BuilderInterface;
use Xylemical\Router\Definition\Argument\EnvironmentArgument;
use Xylemical\Router\Definition\ArgumentInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides an environment argument builder.
 */
class EnvironmentArgumentBuilder extends ArgumentBuilderBase {

  /**
   * {@inheritdoc}
   */
  public function build(mixed $argument, RouteInterface $route, BuilderInterface $builder): ?ArgumentInterface {
    if (is_string($argument) && preg_match('/^%(.*?)(?::(.*?))?%$/', $argument, $match)) {
      return new EnvironmentArgument($match[1], $match[2] ?? NULL);
    }
    return NULL;
  }

}
