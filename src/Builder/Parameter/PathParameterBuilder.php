<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder\Parameter;

use Xylemical\Router\Builder\BuilderInterface;
use Xylemical\Router\Builder\ParameterBuilderBase;
use Xylemical\Router\Definition\Parameter;
use Xylemical\Router\Definition\ParameterInterface;
use Xylemical\Router\Definition\RouteInterface;
use function str_starts_with;

/**
 * Provides for an extended path parameter.
 */
class PathParameterBuilder extends ParameterBuilderBase {

  /**
   * {@inheritdoc}
   */
  public function build(string $segment, array $parameters, RouteInterface $route, BuilderInterface $builder): ?ParameterInterface {
    if (str_starts_with($segment, '!')) {
      $name = substr($segment, 1);
      return new Parameter($name, '.*?');
    }
    return NULL;
  }

}
