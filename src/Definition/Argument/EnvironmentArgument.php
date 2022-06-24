<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition\Argument;

use Xylemical\Code\Php\Php;
use Xylemical\Router\Definition\Argument;

/**
 * Provides an environmental variable argument.
 */
class EnvironmentArgument extends Argument {

  /**
   * The default value for the environment argument.
   *
   * @var mixed
   */
  protected mixed $default;

  /**
   * EnvironmentArgument constructor.
   *
   * @param mixed $name
   *   The name.
   * @param mixed $default
   *   The default value.
   */
  public function __construct(mixed $name, mixed $default) {
    parent::__construct($name);
    $this->default = $default;
  }

  /**
   * {@inheritdoc}
   */
  public function compile(array &$variables): string {
    $name = Php::export($this->value);
    $default = Php::export($this->default);
    return "getenv({$name}) !== FALSE ? getenv($name) : {$default}";
  }

}
