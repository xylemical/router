<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

/**
 * Provides an abstract router source.
 */
class AbstractSource implements SourceInterface {

  /**
   * The definition class.
   *
   * @var string
   */
  protected string $class = Definition::class;

  /**
   * The route definitions.
   *
   * @var \Xylemical\Router\Definition\RouteDefinition[]
   */
  protected array $routes = [];

  /**
   * The route builders.
   *
   * @var string[]
   */
  protected array $routeBuilders = [];

  /**
   * The parameter builders.
   *
   * @var string[]
   */
  protected array $parameterBuilders = [];

  /**
   * The argument builders.
   *
   * @var string[]
   */
  protected array $argumentBuilders = [];

  /**
   * The callable builders.
   *
   * @var string[]
   */
  protected array $controllerBuilders = [];

  /**
   * The modifiers.
   *
   * @var string[]
   */
  protected array $modifiers = [];

  /**
   * The source timestamp.
   *
   * @var int
   */
  protected int $timestamp = 0;

  /**
   * {@inheritdoc}
   */
  public function load(): static {
    $source = $this->doLoad();

    $this->class = $source['class'] ?? $this->class;
    $this->routeBuilders = array_unique($source['route_builders'] ?? []);
    $this->parameterBuilders = array_unique($source['parameter_builders'] ?? []);
    $this->controllerBuilders = array_unique($source['controller_builders'] ?? []);
    $this->routes = [];
    foreach ($source['routes'] ?? [] as $name => $definition) {
      $this->routes[$name] = new RouteDefinition($name, $definition);
    }
    $this->modifiers = array_unique($source['modifiers'] ?? []);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getClass(): string {
    return $this->class;
  }

  /**
   * {@inheritdoc}
   */
  public function getRoutes(): array {
    return $this->routes;
  }

  /**
   * {@inheritdoc}
   */
  public function getRouteBuilders(): array {
    return $this->routeBuilders;
  }

  /**
   * {@inheritdoc}
   */
  public function getParameterBuilders(): array {
    return $this->parameterBuilders;
  }

  /**
   * {@inheritdoc}
   */
  public function getArgumentBuilders(): array {
    return $this->argumentBuilders;
  }

  /**
   * {@inheritdoc}
   */
  public function getControllerBuilders(): array {
    return $this->controllerBuilders;
  }

  /**
   * {@inheritdoc}
   */
  public function getModifiers(): array {
    return $this->modifiers;
  }

  /**
   * {@inheritdoc}
   */
  public function getTimestamp(): int {
    if (!$this->timestamp) {
      $this->timestamp = time();
    }
    return $this->timestamp;
  }

  /**
   * Loads the source definition.
   *
   * @return array
   *   The definition.
   */
  protected function doLoad(): array {
    return [];
  }

}
