<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

/**
 * Provides the definition for the router.
 */
interface DefinitionInterface {

  /**
   * DefinitionInterface constructor.
   *
   * @param string $class
   *   The router class.
   * @param \Xylemical\Router\Definition\RouteInterface[] $routes
   *   The routes.
   */
  public function __construct(string $class, array $routes);

  /**
   * Get the class for the router.
   *
   * @return string
   *   The class.
   */
  public function getClass(): string;

  /**
   * Get the route definitions.
   *
   * @return \Xylemical\Router\Definition\RouteInterface[]
   *   The routes.
   */
  public function getRoutes(): array;

  /**
   * Get a route.
   *
   * @param string $name
   *   The route name.
   *
   * @return \Xylemical\Router\Definition\RouteInterface|null
   *   The route or NULL.
   */
  public function getRoute(string $name): ?RouteInterface;

  /**
   * Set the routes of the definition.
   *
   * @param \Xylemical\Router\Definition\RouteInterface[] $routes
   *   The routes.
   *
   * @return $this
   */
  public function setRoutes(array $routes): static;

  /**
   * Add routes to the definition.
   *
   * @param \Xylemical\Router\Definition\RouteInterface[] $routes
   *   The routes.
   *
   * @return $this
   */
  public function addRoutes(array $routes): static;

  /**
   * Add a route.
   *
   * @param \Xylemical\Router\Definition\RouteInterface $route
   *   The route.
   *
   * @return $this
   */
  public function addRoute(RouteInterface $route): static;

  /**
   * Remove a route from the definition.
   *
   * @param string $name
   *   The route name.
   *
   * @return $this
   */
  public function removeRoute(string $name): static;

}
