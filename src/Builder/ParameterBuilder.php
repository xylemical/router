<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Builder\Parameter\GenericParameterBuilder;
use Xylemical\Router\Definition\ParameterInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides parameter builder service collector.
 */
class ParameterBuilder implements ParameterBuilderInterface {

  /**
   * The parameter builders.
   *
   * @var \Xylemical\Router\Builder\ParameterBuilderInterface[]
   */
  protected array $builders = [];

  /**
   * The default parameter builder.
   *
   * @var \Xylemical\Router\Builder\ParameterBuilderInterface
   */
  protected ParameterBuilderInterface $defaultBuilder;

  /**
   * {@inheritdoc}
   */
  public function __construct() {
    $this->defaultBuilder = new GenericParameterBuilder();
  }

  /**
   * Set the builders.
   *
   * @param \Xylemical\Router\Builder\ParameterBuilderInterface[] $builders
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
   * Add parameter builders.
   *
   * @param \Xylemical\Router\Builder\ParameterBuilderInterface[] $builders
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
   * Add a parameter builder.
   *
   * @param \Xylemical\Router\Builder\ParameterBuilderInterface $builder
   *   The builder.
   *
   * @return $this
   */
  public function addBuilder(ParameterBuilderInterface $builder): static {
    $this->builders[] = $builder;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function build(string $segment, array $parameters, RouteInterface $route, BuilderInterface $builder): ?ParameterInterface {
    foreach ($this->builders as $item) {
      if ($result = $item->build($segment, $parameters, $route, $builder)) {
        return $result;
      }
    }
    return $this->defaultBuilder->build($segment, $parameters, $route, $builder);
  }

}
