<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

/**
 * Provides a generic definition.
 */
class Definition implements DefinitionInterface {

  /**
   * The router class.
   *
   * @var string
   */
  protected string $class;

  /**
   * The routes.
   *
   * @var \Xylemical\Router\Definition\RouteInterface[]
   */
  protected array $definitions = [];

  /**
   * {@inheritdoc}
   */
  public function __construct(string $class, array $routes = []) {
    $this->class = $class;
    $this->addRoutes($routes);
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
    return $this->definitions;
  }

  /**
   * {@inheritdoc}
   */
  public function getRoute(string $name): ?RouteInterface {
    return $this->definitions[$name] ?? NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function setRoutes(array $routes): static {
    $this->definitions = [];
    $this->addRoutes($routes);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function addRoutes(array $routes): static {
    foreach ($routes as $route) {
      $this->addRoute($route);
    }
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function addRoute(RouteInterface $route): static {
    $this->definitions[$route->getName()] = $route;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function removeRoute(string $name): static {
    unset($this->definitions[$name]);
    return $this;
  }

}
