<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

/**
 * Provides a route definition.
 */
interface RouteInterface {

  /**
   * RouteInterface constructor.
   *
   * @param string $name
   *   The name.
   * @param string $path
   *   The path.
   */
  public function __construct(string $name, string $path);

  /**
   * Get the name.
   *
   * @return string
   *   The name.
   */
  public function getName(): string;

  /**
   * Get the class used for the route.
   *
   * @return string
   *   The class.
   */
  public function getClass(): string;

  /**
   * Set the route class.
   *
   * @param string $class
   *   The class.
   *
   * @return $this
   */
  public function setClass(string $class): static;

  /**
   * Get the path.
   *
   * @return \Xylemical\Router\Definition\Path
   *   The path.
   */
  public function getPath(): Path;

  /**
   * Get the methods that apply to the route.
   *
   * @return string[]
   *   The methods.
   */
  public function getMethods(): array;

  /**
   * Check the route has a method.
   *
   * @param string $method
   *   The method.
   *
   * @return bool
   *   The result.
   */
  public function hasMethod(string $method): bool;

  /**
   * Add a method.
   *
   * @param string $method
   *   The method.
   *
   * @return $this
   */
  public function addMethod(string $method): static;

  /**
   * Remove a method.
   *
   * @param string $method
   *   The method.
   *
   * @return $this
   */
  public function removeMethod(string $method): static;

  /**
   * Get the parameters.
   *
   * @return \Xylemical\Router\Definition\ParameterInterface[]
   *   The parameters.
   */
  public function getParameters(): array;

  /**
   * Set the segment parameter.
   *
   * @param int $segment
   *   The segment.
   * @param \Xylemical\Router\Definition\ParameterInterface $parameter
   *   The parameter.
   *
   * @return $this
   */
  public function setParameter(int $segment, ParameterInterface $parameter): static;

  /**
   * Get the controller definition.
   *
   * @return \Xylemical\Router\Definition\ControllerInterface|null
   *   The controller.
   */
  public function getController(): ?ControllerInterface;

  /**
   * Set the controller.
   *
   * @param \Xylemical\Router\Definition\ControllerInterface|null $controller
   *   The controller definition.
   *
   * @return $this
   */
  public function setController(?ControllerInterface $controller): static;

  /**
   * Compile the instantiation of the route.
   *
   * @return string
   *   The compiled code.
   */
  public function compile(): string;

}
