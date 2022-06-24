<?php

declare(strict_types=1);

namespace Xylemical\Router;

use function call_user_func_array;
use function func_get_args;

/**
 * Provides a generic controller object.
 */
class Controller implements ControllerInterface {

  /**
   * The controller.
   *
   * @var mixed
   */
  protected mixed $controller;

  /**
   * The controller method.
   *
   * @var string
   */
  protected string $method;

  /**
   * The arguments.
   *
   * @var array
   */
  protected array $arguments;

  /**
   * CallableObject constructor.
   *
   * @param mixed $controller
   *   The controller object.
   * @param string $method
   *   The method.
   * @param array $arguments
   *   The arguments.
   */
  public function __construct(mixed $controller, string $method, array $arguments = []) {
    $this->controller = $controller;
    $this->method = $method;
    $this->arguments = $arguments;
  }

  /**
   * Get the controller.
   *
   * @return mixed
   *   The controller.
   */
  public function getController(): mixed {
    return $this->controller;
  }

  /**
   * Get the method.
   *
   * @return string
   *   The method.
   */
  public function getMethod(): string {
    return $this->method;
  }

  /**
   * Get the arguments.
   *
   * @return array
   *   The arguments.
   */
  public function getArguments(): array {
    return $this->arguments;
  }

  /**
   * {@inheritdoc}
   */
  public function __invoke(): mixed {
    $args = array_merge($this->arguments, func_get_args());
    return call_user_func_array([$this->controller, $this->method], $args);
  }

}
