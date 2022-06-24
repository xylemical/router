<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Definition\ControllerInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides a base controller builder.
 */
abstract class ControllerBuilderBase implements ControllerBuilderInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct() {
  }

  /**
   * {@inheritdoc}
   */
  abstract public function build(mixed $controller, array $arguments, RouteInterface $route, BuilderInterface $builder): ?ControllerInterface;

}
