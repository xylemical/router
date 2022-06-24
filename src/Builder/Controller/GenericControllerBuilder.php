<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder\Controller;

use Xylemical\Router\Builder\BuilderInterface;
use Xylemical\Router\Builder\ControllerBuilderBase;
use Xylemical\Router\Controller as DefaultController;
use Xylemical\Router\Definition\Controller;
use Xylemical\Router\Definition\ControllerInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides a generic controller builder.
 */
class GenericControllerBuilder extends ControllerBuilderBase {

  /**
   * {@inheritdoc}
   */
  public function build(mixed $controller, array $arguments, RouteInterface $route, BuilderInterface $builder): ?ControllerInterface {
    if (!isset($controller['callable'])) {
      return NULL;
    }
    $parts = explode('::', $controller['callable']);
    if (count($parts) !== 2) {
      return NULL;
    }

    return new Controller(
      $controller['class'] ?? DefaultController::class,
      $parts[0],
      $parts[1],
      $arguments
    );
  }

}
