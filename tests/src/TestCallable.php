<?php

declare(strict_types=1);

namespace Xylemical\Router;

/**
 * Provides a callable that is used to test the controller behaviour.
 */
class TestCallable {

  /**
   * A test call.
   *
   * @param string $a
   *   First variable.
   * @param string $b
   *   Second variable.
   * @param string $c
   *   Third variable.
   *
   * @return string
   *   The result.
   */
  public function call(string $a = 'a', string $b = 'b', string $c = 'c'): string {
    return $a . $b . $c;
  }

}
