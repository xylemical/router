<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

/**
 * Provides the controller definition.
 */
interface ControllerInterface {

  /**
   * Compile the controller.
   *
   * @param array $variables
   *   The variable names.
   *
   * @return string
   *   The controller.
   */
  public function compile(array &$variables): string;

}
