<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Builder\Controller\GenericControllerBuilder;
use Xylemical\Router\Definition\ControllerInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides controller builder service collector.
 */
class ControllerBuilder implements ControllerBuilderInterface {

  /**
   * The controller builders.
   *
   * @var \Xylemical\Router\Builder\ControllerBuilderInterface[]
   */
  protected array $builders = [];

  /**
   * The default controller builder.
   *
   * @var \Xylemical\Router\Builder\ControllerBuilderInterface
   */
  protected ControllerBuilderInterface $defaultBuilder;

  /**
   * {@inheritdoc}
   */
  public function __construct() {
    $this->defaultBuilder = new GenericControllerBuilder();
  }

  /**
   * Set the builders.
   *
   * @param \Xylemical\Router\Builder\ControllerBuilderInterface[] $builders
   *   The builders.
   *
   * @return $this
   */
  public function setBuilders(array $builders): static {
    $this->builders = [];
    $this->addBuilders($builders);
    return $this;
  }

  /**
   * Add controller builders.
   *
   * @param \Xylemical\Router\Builder\ControllerBuilderInterface[] $builders
   *   The builders.
   *
   * @return $this
   */
  public function addBuilders(array $builders): static {
    foreach ($builders as $builder) {
      $this->addBuilder($builder);
    }
    return $this;
  }

  /**
   * Add a controller builder.
   *
   * @param \Xylemical\Router\Builder\ControllerBuilderInterface $builder
   *   The builder.
   *
   * @return $this
   */
  public function addBuilder(ControllerBuilderInterface $builder): static {
    $this->builders[] = $builder;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function build(mixed $controller, array $arguments, RouteInterface $route, BuilderInterface $builder): ?ControllerInterface {
    foreach ($this->builders as $item) {
      if ($result = $item->build($controller, $arguments, $route, $builder)) {
        return $result;
      }
    }
    return $this->defaultBuilder->build($controller, $arguments, $route, $builder);
  }

}
