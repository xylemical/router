<?php

declare(strict_types=1);

namespace Xylemical\Router;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Provide a generic route.
 */
class Route implements RouteInterface {

  /**
   * The route name.
   *
   * @var string
   */
  protected string $name;

  /**
   * The route parameters.
   *
   * @var array
   */
  protected array $parameters;

  /**
   * The originating server request.
   *
   * @var \Psr\Http\Message\ServerRequestInterface|null
   */
  protected ?ServerRequestInterface $request = NULL;

  /**
   * The controller for the route.
   *
   * @var \Xylemical\Router\ControllerInterface|null
   */
  protected ?ControllerInterface $controller = NULL;

  /**
   * Route constructor.
   *
   * @param string $name
   *   The name.
   * @param array $parameters
   *   The arguments.
   */
  public function __construct(string $name, array $parameters) {
    $this->name = $name;
    $this->parameters = $parameters;
  }

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * {@inheritdoc}
   */
  public function getParameters(): array {
    return $this->parameters;
  }

  /**
   * {@inheritdoc}
   */
  public function getRequest(): ServerRequestInterface {
    return $this->request;
  }

  /**
   * {@inheritdoc}
   */
  public function setRequest(?ServerRequestInterface $request): static {
    $this->request = $request;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getController(): ?ControllerInterface {
    return $this->controller;
  }

  /**
   * {@inheritdoc}
   */
  public function setController(?ControllerInterface $controller): static {
    $this->controller = $controller;
    return $this;
  }

}
