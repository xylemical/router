<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Builder\Route\GenericRouteBuilder;
use Xylemical\Router\Definition\RouteDefinition;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides a generic service builder collector.
 */
class RouteBuilder implements RouteBuilderInterface {

  /**
   * The route builders.
   *
   * @var \Xylemical\Router\Builder\RouteBuilderInterface[]
   */
  protected array $builders = [];

  /**
   * The default route builder.
   *
   * @var \Xylemical\Router\Builder\RouteBuilderInterface
   */
  protected RouteBuilderInterface $defaultBuilder;

  /**
   * {@inheritdoc}
   */
  public function __construct() {
    $this->defaultBuilder = new GenericRouteBuilder();
  }

  /**
   * Set the builders.
   *
   * @param \Xylemical\Router\Builder\RouteBuilderInterface[] $builders
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
   * Add route builders.
   *
   * @param \Xylemical\Router\Builder\RouteBuilderInterface[] $builders
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
   * Add a route builder.
   *
   * @param \Xylemical\Router\Builder\RouteBuilderInterface $builder
   *   The builder.
   *
   * @return $this
   */
  public function addBuilder(RouteBuilderInterface $builder): static {
    $this->builders[] = $builder;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteDefinition $route, BuilderInterface $builder): ?RouteInterface {
    foreach ($this->builders as $item) {
      if ($result = $item->build($route, $builder)) {
        return $result;
      }
    }
    return $this->defaultBuilder->build($route, $builder);
  }

}
