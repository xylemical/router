<?php

declare(strict_types=1);

namespace Xylemical\Router;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Provides a route.
 */
interface RouteInterface {

  /**
   * RouteInterface constructor.
   *
   * @param string $name
   *   The route name.
   * @param string[] $parameters
   *   The route parameters.
   */
  public function __construct(string $name, array $parameters);

  /**
   * The route information.
   *
   * @return string
   *   The name.
   */
  public function getName(): string;

  /**
   * Get the route parameters.
   *
   * @return string[]
   *   The parameters.
   */
  public function getParameters(): array;

  /**
   * Get the request for the route.
   *
   * @return \Psr\Http\Message\ServerRequestInterface|null
   *   The request.
   */
  public function getRequest(): ?ServerRequestInterface;

  /**
   * Set the request for the route.
   *
   * @param \Psr\Http\Message\ServerRequestInterface|null $request
   *   The request.
   *
   * @return $this
   */
  public function setRequest(?ServerRequestInterface $request): static;

  /**
   * Get the controller object for the route.
   *
   * @return \Xylemical\Router\ControllerInterface|null
   *   The route.
   */
  public function getController(): ?ControllerInterface;

  /**
   * Set the callable object for the route.
   *
   * @param \Xylemical\Router\ControllerInterface|null $controller
   *   The controller.
   *
   * @return $this
   */
  public function setController(?ControllerInterface $controller): static;

}
