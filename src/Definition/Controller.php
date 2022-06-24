<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use Xylemical\Code\Php\Php;

/**
 * Provides the controller definition.
 */
class Controller implements ControllerInterface {

  /**
   * The controller class.
   *
   * @var string
   */
  protected string $class;

  /**
   * The invokable controller class.
   *
   * @var string
   */
  protected string $controller;

  /**
   * The method.
   *
   * @var string
   */
  protected string $method;

  /**
   * The arguments.
   *
   * @var \Xylemical\Router\Definition\ArgumentInterface[]
   */
  protected array $arguments;

  /**
   * Controller constructor.
   *
   * @param string $class
   *   The controller class.
   * @param string $controller
   *   The invokable controller.
   * @param string $method
   *   The invokable method.
   * @param \Xylemical\Router\Definition\ArgumentInterface[] $arguments
   *   The arguments.
   */
  public function __construct(string $class, string $controller, string $method, array $arguments) {
    $this->class = $class;
    $this->controller = $controller;
    $this->method = $method;
    $this->arguments = $arguments;
  }

  /**
   * Get the controller class.
   *
   * @return string
   *   The class.
   */
  public function getClass(): string {
    return $this->class;
  }

  /**
   * Set the controller class.
   *
   * @param string $class
   *   The class.
   *
   * @return $this
   */
  public function setClass(string $class): static {
    $this->class = $class;
    return $this;
  }

  /**
   * Get the invokable controller class.
   *
   * @return string
   *   The class.
   */
  public function getController(): string {
    return $this->controller;
  }

  /**
   * Set the invokable controller class.
   *
   * @param string $controller
   *   The class.
   *
   * @return $this
   */
  public function setController(string $controller): static {
    $this->controller = $controller;
    return $this;
  }

  /**
   * Get the method used for the invokable controller class.
   *
   * @return string
   *   The method.
   */
  public function getMethod(): string {
    return $this->method;
  }

  /**
   * Set the method used for the invokable controller class.
   *
   * @param string $method
   *   The method.
   *
   * @return $this
   */
  public function setMethod(string $method): static {
    $this->method = $method;
    return $this;
  }

  /**
   * Get the arguments passed to the controller.
   *
   * @return \Xylemical\Router\Definition\ArgumentInterface[]
   *   The arguments.
   */
  public function getArguments(): array {
    return $this->arguments;
  }

  /**
   * Set the arguments.
   *
   * @param \Xylemical\Router\Definition\ArgumentInterface[] $arguments
   *   The arguments.
   *
   * @return $this
   */
  public function setArguments(array $arguments): static {
    $this->arguments = [];
    $this->addArguments($arguments);
    return $this;
  }

  /**
   * Add arguments to the controller.
   *
   * @param \Xylemical\Router\Definition\ArgumentInterface[] $arguments
   *   The arguments.
   *
   * @return $this
   */
  public function addArguments(array $arguments): static {
    foreach ($arguments as $argument) {
      $this->addArgument($argument);
    }
    return $this;
  }

  /**
   * Add an argument.
   *
   * @param \Xylemical\Router\Definition\ArgumentInterface $argument
   *   The argument.
   *
   * @return $this
   */
  public function addArgument(ArgumentInterface $argument): static {
    $this->arguments[] = $argument;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function compile(array &$variables): string {
    $class = trim($this->class, '\\');
    $controller = Php::export(trim($this->controller, '\\'));
    $method = Php::export($this->method);
    $source = "new \\{$class}(\n  {$controller},\n  {$method},\n  [";
    if (count($this->arguments)) {
      $source .= "\n";
      foreach ($this->arguments as $index => $argument) {
        $source .= !$index ? '    ' : ",\n    ";
        $source .= $argument->compile($variables);
      }
      $source .= ",\n  ";

    }
    $source .= "]\n)\n";
    return $source;
  }

}
