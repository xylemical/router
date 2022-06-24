<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use function array_filter;
use function in_array;
use function is_null;
use function time;

/**
 * Provides a generic in-memory source.
 */
class Source extends AbstractSource {

  /**
   * Source constructor.
   *
   * @param \Xylemical\Router\Definition\SourceInterface|null $original
   *   The original source.
   */
  public function __construct(?SourceInterface $original = NULL) {
    if (!$original) {
      return;
    }
    $this->class = $original->getClass();
    $this->routeBuilders = $original->getRouteBuilders();
    $this->parameterBuilders = $original->getParameterBuilders();
    $this->argumentBuilders = $original->getArgumentBuilders();
    $this->controllerBuilders = $original->getControllerBuilders();
    $this->modifiers = $original->getModifiers();
    $this->timestamp = $original->getTimestamp();
    foreach ($original->getRoutes() as $route) {
      $route = clone($route);
      $this->routes[$route->getName()] = $route;
    }
  }

  /**
   * Set the definition class.
   *
   * @param string $class
   *   The definition class.
   *
   * @return $this
   */
  public function setClass(string $class): static {
    $this->class = $class;
    return $this;
  }

  /**
   * Get a route.
   *
   * @param string $name
   *   The route name.
   *
   * @return \Xylemical\Router\Definition\RouteDefinition|null
   *   The route or NULL.
   */
  public function getRoute(string $name): ?RouteDefinition {
    return $this->routes[$name] ?? NULL;
  }

  /**
   * Check for a route.
   *
   * @param string $name
   *   The route.
   *
   * @return bool
   *   The result.
   */
  public function hasRoute(string $name): bool {
    return isset($this->routes[$name]);
  }

  /**
   * Set a route definition.
   *
   * @param \Xylemical\Router\Definition\RouteDefinition $route
   *   The route definition.
   *
   * @return $this
   */
  public function setRoute(RouteDefinition $route): static {
    $this->routes[$route->getName()] = $route;
    return $this;
  }

  /**
   * Set the route builders.
   *
   * @param string[] $builders
   *   The route builders.
   *
   * @return $this
   */
  public function setRouteBuilders(array $builders): static {
    $this->routeBuilders = [];
    foreach ($builders as $builder) {
      $this->addRouteBuilder($builder);
    }
    return $this;
  }

  /**
   * Check for route builder.
   *
   * @param string $class
   *   The route builder.
   *
   * @return bool
   *   The result.
   */
  public function hasRouteBuilder(string $class): bool {
    return in_array($class, $this->routeBuilders);
  }

  /**
   * Add a route builder.
   *
   * @param string $class
   *   The route builder.
   *
   * @return $this
   */
  public function addRouteBuilder(string $class): static {
    if (!in_array($class, $this->routeBuilders)) {
      $this->routeBuilders[] = $class;
    }
    return $this;
  }

  /**
   * Remove a route builder.
   *
   * @param string $class
   *   The route builder.
   *
   * @return $this
   */
  public function removeRouteBuilder(string $class): static {
    $this->routeBuilders = array_filter(
      $this->routeBuilders,
      function ($route) use ($class) {
        return $route !== $class;
      }
    );
    return $this;
  }

  /**
   * Set the parameter builders.
   *
   * @param string[] $builders
   *   The parameter builders.
   *
   * @return $this
   */
  public function setParameterBuilders(array $builders): static {
    $this->parameterBuilders = [];
    foreach ($builders as $builder) {
      $this->addParameterBuilder($builder);
    }
    return $this;
  }

  /**
   * Check for parameter builder.
   *
   * @param string $class
   *   The parameter builder.
   *
   * @return bool
   *   The result.
   */
  public function hasParameterBuilder(string $class): bool {
    return in_array($class, $this->parameterBuilders);
  }

  /**
   * Add a parameter builder.
   *
   * @param string $class
   *   The parameter builder.
   *
   * @return $this
   */
  public function addParameterBuilder(string $class): static {
    if (!in_array($class, $this->parameterBuilders)) {
      $this->parameterBuilders[] = $class;
    }
    return $this;
  }

  /**
   * Remove a parameter builder.
   *
   * @param string $class
   *   The parameter builder.
   *
   * @return $this
   */
  public function removeParameterBuilder(string $class): static {
    $this->parameterBuilders = array_filter(
      $this->parameterBuilders,
      function ($parameter) use ($class) {
        return $parameter !== $class;
      }
    );
    return $this;
  }

  /**
   * Set the argument builders.
   *
   * @param string[] $builders
   *   The argument builders.
   *
   * @return $this
   */
  public function setArgumentBuilders(array $builders): static {
    $this->argumentBuilders = [];
    foreach ($builders as $builder) {
      $this->addArgumentBuilder($builder);
    }
    return $this;
  }

  /**
   * Check for argument builder.
   *
   * @param string $class
   *   The argument builder.
   *
   * @return bool
   *   The result.
   */
  public function hasArgumentBuilder(string $class): bool {
    return in_array($class, $this->argumentBuilders);
  }

  /**
   * Add a argument builder.
   *
   * @param string $class
   *   The argument builder.
   *
   * @return $this
   */
  public function addArgumentBuilder(string $class): static {
    if (!in_array($class, $this->argumentBuilders)) {
      $this->argumentBuilders[] = $class;
    }
    return $this;
  }

  /**
   * Remove a argument builder.
   *
   * @param string $class
   *   The argument builder.
   *
   * @return $this
   */
  public function removeArgumentBuilder(string $class): static {
    $this->argumentBuilders = array_filter(
      $this->argumentBuilders,
      function ($argument) use ($class) {
        return $argument !== $class;
      }
    );
    return $this;
  }

  /**
   * Set the controller builders.
   *
   * @param string[] $builders
   *   The controller builders.
   *
   * @return $this
   */
  public function setControllerBuilders(array $builders): static {
    $this->controllerBuilders = [];
    foreach ($builders as $builder) {
      $this->addControllerBuilder($builder);
    }
    return $this;
  }

  /**
   * Check for controller builder.
   *
   * @param string $class
   *   The controller builder.
   *
   * @return bool
   *   The result.
   */
  public function hasControllerBuilder(string $class): bool {
    return in_array($class, $this->controllerBuilders);
  }

  /**
   * Add a controller builder.
   *
   * @param string $class
   *   The controller builder.
   *
   * @return $this
   */
  public function addControllerBuilder(string $class): static {
    if (!in_array($class, $this->controllerBuilders)) {
      $this->controllerBuilders[] = $class;
    }
    return $this;
  }

  /**
   * Remove a controller builder.
   *
   * @param string $class
   *   The controller builder.
   *
   * @return $this
   */
  public function removeControllerBuilder(string $class): static {
    $this->controllerBuilders = array_filter(
      $this->controllerBuilders,
      function ($controller) use ($class) {
        return $controller !== $class;
      }
    );
    return $this;
  }

  /**
   * Sets the timestamp.
   *
   * @param int|null $timestamp
   *   The timestamp.
   *
   * @return $this
   */
  public function setTimestamp(?int $timestamp): static {
    if (is_null($timestamp)) {
      $this->timestamp = time();
    }
    else {
      $this->timestamp = $timestamp;
    }
    return $this;
  }

}
