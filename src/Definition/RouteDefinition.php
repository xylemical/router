<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use Xylemical\Router\Route;

/**
 * Provide a route definition.
 */
class RouteDefinition {

  /**
   * The name of the route.
   *
   * @var string
   */
  protected string $name;

  /**
   * The route definition.
   *
   * @var array
   */
  protected array $definition;

  /**
   * RouteDefinition constructor.
   *
   * @param string $name
   *   The route name.
   * @param array $definition
   *   The route definition.
   */
  public function __construct(string $name, array $definition = []) {
    $this->name = $name;
    $this->definition = $definition;
    $this->definition += [
      'path' => '',
      'methods' => [],
      'parameters' => [],
      'arguments' => [],
    ];
  }

  /**
   * Get the name.
   *
   * @return string
   *   The name.
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * Get the path.
   *
   * @return string
   *   The path.
   */
  public function getPath(): string {
    return $this->definition['path'];
  }

  /**
   * Set the path.
   *
   * @param string $path
   *   The path.
   *
   * @return $this
   */
  public function setPath(string $path): static {
    $this->definition['path'] = $path;
    return $this;
  }

  /**
   * Get the class used for the route.
   *
   * @return string
   *   The route.
   */
  public function getClass(): string {
    return $this->definition['class'] ?? Route::class;
  }

  /**
   * Set the class used for the route.
   *
   * @param string $class
   *   The class.
   *
   * @return $this
   */
  public function setClass(string $class): static {
    $this->definition['class'] = $class;
    return $this;
  }

  /**
   * Get the methods.
   *
   * @return string[]
   *   The methods.
   */
  public function getMethods(): array {
    return $this->definition['methods'];
  }

  /**
   * Set the methods.
   *
   * @param string[] $methods
   *   The methods.
   *
   * @return $this
   */
  public function setMethods(array $methods): static {
    $this->definition['methods'] = $methods;
    return $this;
  }

  /**
   * Get the controller.
   *
   * @return array
   *   The controller.
   */
  public function getController(): array {
    return $this->definition['controller'] ?? [];
  }

  /**
   * Set the controller.
   *
   * @param array $controller
   *   The controller definition.
   *
   * @return $this
   */
  public function setController(array $controller): static {
    $this->definition['controller'] = $controller;
    return $this;
  }

  /**
   * Get the parameters.
   *
   * @return array
   *   The parameters.
   */
  public function getParameters(): array {
    return $this->definition['parameters'] ?? [];
  }

  /**
   * Get a parameter.
   *
   * @param string $name
   *   The name.
   *
   * @return array
   *   The parameter definition.
   */
  public function getParameter(string $name): array {
    return $this->definition['parameters'][$name] ?? [];
  }

  /**
   * Set the parameters.
   *
   * @param array $parameters
   *   The parameters.
   *
   * @return $this
   */
  public function setParameters(array $parameters): static {
    $this->definition['parameters'] = $parameters;
    return $this;
  }

  /**
   * Set a parameter.
   *
   * @param string $name
   *   The parameter.
   * @param array $definition
   *   The definition.
   *
   * @return $this
   */
  public function setParameter(string $name, array $definition): static {
    $this->definition['parameters'][$name] = $definition;
    return $this;
  }

  /**
   * Get the arguments used to call the controller.
   *
   * @return array
   *   The arguments.
   */
  public function getArguments(): array {
    return $this->definition['arguments'] ?? [];
  }

  /**
   * Set the arguments.
   *
   * @param array $arguments
   *   The arguments.
   *
   * @return $this
   */
  public function setArguments(array $arguments): static {
    $this->definition['arguments'] = $arguments;
    return $this;
  }

}
