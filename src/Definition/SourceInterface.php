<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

/**
 * Provides the router source.
 */
interface SourceInterface {

  /**
   * Load the source.
   *
   * This is required to be called before calling any of the other functions,
   * as the source is to be lazy-loaded.
   *
   * @return $this
   */
  public function load(): static;

  /**
   * Get the route source class.
   *
   * @return string
   *   The class.
   */
  public function getClass(): string;

  /**
   * Get the routes.
   *
   * @return \Xylemical\Router\Definition\RouteDefinition[]
   *   The routes.
   */
  public function getRoutes(): array;

  /**
   * Get the route builders.
   *
   * @return string[]
   *   The builders.
   */
  public function getRouteBuilders(): array;

  /**
   * Get the parameter builders.
   *
   * @return string[]
   *   The builders.
   */
  public function getParameterBuilders(): array;

  /**
   * Get the argument builders.
   *
   * @return string[]
   *   The builders.
   */
  public function getArgumentBuilders(): array;

  /**
   * Get the controller builders.
   *
   * @return string[]
   *   The builders.
   */
  public function getControllerBuilders(): array;

  /**
   * Get the source modifiers.
   *
   * @return string[]
   *   The modifiers.
   */
  public function getModifiers(): array;

  /**
   * The timestamp for when the sources were last updated.
   *
   * @return int
   *   The timestamp.
   */
  public function getTimestamp(): int;

}
