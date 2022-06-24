<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Builder\Argument\GenericArgumentBuilder;
use Xylemical\Router\Definition\ArgumentInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Provides argument builder service collector.
 */
class ArgumentBuilder implements ArgumentBuilderInterface {

  /**
   * The argument builders.
   *
   * @var \Xylemical\Router\Builder\ArgumentBuilderInterface[]
   */
  protected array $builders = [];

  /**
   * The default argument builder.
   *
   * @var \Xylemical\Router\Builder\ArgumentBuilderInterface
   */
  protected ArgumentBuilderInterface $defaultBuilder;

  /**
   * {@inheritdoc}
   */
  public function __construct() {
    $this->defaultBuilder = new GenericArgumentBuilder();
  }

  /**
   * Set the builders.
   *
   * @param \Xylemical\Router\Builder\ArgumentBuilderInterface[] $builders
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
   * Add argument builders.
   *
   * @param \Xylemical\Router\Builder\ArgumentBuilderInterface[] $builders
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
   * Add a argument builder.
   *
   * @param \Xylemical\Router\Builder\ArgumentBuilderInterface $builder
   *   The builder.
   *
   * @return $this
   */
  public function addBuilder(ArgumentBuilderInterface $builder): static {
    $this->builders[] = $builder;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function build(mixed $argument, RouteInterface $route, BuilderInterface $builder): ?ArgumentInterface {
    foreach ($this->builders as $item) {
      if ($result = $item->build($argument, $route, $builder)) {
        return $result;
      }
    }
    return $this->defaultBuilder->build($argument, $route, $builder);
  }

}
