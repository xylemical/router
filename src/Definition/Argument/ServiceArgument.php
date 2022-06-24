<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition\Argument;

use Xylemical\Code\Php\Php;
use Xylemical\Router\Definition\Argument;

/**
 * Provides a service argument for the controller.
 */
class ServiceArgument extends Argument {

  /**
   * {@inheritdoc}
   */
  public function compile(array &$variables): string {
    $name = Php::export($this->value);
    return "{$variables['container']}->get({$name})";
  }

}
