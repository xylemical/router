<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder\Parameter;

use Xylemical\Router\Builder\BuilderInterface;
use Xylemical\Router\Builder\ParameterBuilderBase;
use Xylemical\Router\Definition\Parameter;
use Xylemical\Router\Definition\ParameterInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides a generic parameter builder.
 */
class GenericParameterBuilder extends ParameterBuilderBase {

  /**
   * {@inheritdoc}
   */
  public function build(string $segment, array $parameters, RouteInterface $route, BuilderInterface $builder): ?ParameterInterface {
    if (preg_match('`^{([^}]+)}$`', $segment, $match)) {
      $name = $match[1];
      $regex = $parameters[$name]['regex'] ?? '[^\]]+';
      return new Parameter($name, $regex);
    }
    return NULL;
  }

}
