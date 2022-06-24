<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use Xylemical\Code\Php\Php;

/**
 * Provides a generic argument.
 */
class Argument implements ArgumentInterface {

  /**
   * The argument value.
   *
   * @var mixed
   */
  protected mixed $value;

  /**
   * Argument constructor.
   *
   * @param mixed $value
   *   The value.
   */
  public function __construct(mixed $value) {
    $this->value = $value;
  }

  /**
   * {@inheritdoc}
   */
  public function compile(array &$variables): string {
    return Php::export($this->value);
  }

}
