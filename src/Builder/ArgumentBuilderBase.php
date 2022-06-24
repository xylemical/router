<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Definition\ArgumentInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides a base argument builder.
 */
abstract class ArgumentBuilderBase implements ArgumentBuilderInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct() {
  }

  /**
   * {@inheritdoc}
   */
  abstract public function build(mixed $argument, RouteInterface $route, BuilderInterface $builder): ?ArgumentInterface;

}
