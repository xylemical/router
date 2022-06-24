<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

/**
 * Provides a constructor argument.
 */
interface ArgumentInterface {

  /**
   * Compiles the argument.
   *
   * @param array $variables
   *   The variable names.
   *
   * @return string
   *   The compiled code.
   */
  public function compile(array &$variables): string;

}
