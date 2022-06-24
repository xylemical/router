<?php

declare(strict_types=1);

namespace Xylemical\Router;

/**
 * Provides the callable.
 */
interface ControllerInterface {

  /**
   * Invoke the callable object.
   *
   * Additional parameters can be passed to __invoke, and must be passed in
   * addition to any default parameters.
   *
   * @return mixed
   *   The result.
   */
  public function __invoke(): mixed;

}
