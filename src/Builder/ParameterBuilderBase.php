<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Definition\ParameterInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides a base parameter builder.
 */
abstract class ParameterBuilderBase implements ParameterBuilderInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct() {
  }

  /**
   * {@inheritdoc}
   */
  abstract public function build(string $segment, array $parameters, RouteInterface $route, BuilderInterface $builder): ?ParameterInterface;

}
