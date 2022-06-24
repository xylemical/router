<?php

declare(strict_types=1);

namespace Xylemical\Router;

use Psr\Container\ContainerInterface;
use Xylemical\Router\Builder\Builder;
use Xylemical\Router\Compiler\Compiler;
use Xylemical\Router\Definition\SourceInterface;
use Xylemical\Router\Exception\RouterException;

/**
 * Provides the builder for the router.
 */
class RouterBuilder {

  /**
   * The filename for the compiled router.
   *
   * @var string
   */
  protected string $filename;

  /**
   * The classname used for the compiled router.
   *
   * @var string
   */
  protected string $class;

  /**
   * The router source.
   *
   * @var \Xylemical\Router\Definition\SourceInterface
   */
  protected SourceInterface $source;

  /**
   * The container.
   *
   * @var \Psr\Container\ContainerInterface
   */
  protected ContainerInterface $container;

  /**
   * RouterBuilder constructor.
   *
   * @param \Psr\Container\ContainerInterface $container
   *   The container.
   * @param \Xylemical\Router\Definition\SourceInterface $source
   *   The source.
   * @param string $filename
   *   The filename to store the compiled router.
   * @param string $class
   *   The classname used for the compiled router.
   */
  public function __construct(ContainerInterface $container, SourceInterface $source, string $filename, string $class = 'Xylemical\\Router\\CompiledRouter') {
    $this->container = $container;
    $this->source = $source;
    $this->filename = $filename;
    $this->class = $class;
  }

  /**
   * Get the router from the builder.
   *
   * @return \Xylemical\Router\Router
   *   The router.
   *
   * @throws \Xylemical\Router\Exception\RouterException
   * @throws \Xylemical\Router\Exception\InvalidDefinitionException
   */
  public function getRouter(): Router {
    if (!file_exists($this->filename) ||
      ($this->source->getTimestamp() > filemtime($this->filename))) {
      $this->doBuildRouter();
    }
    if (!class_exists($this->class, FALSE)) {
      include $this->filename;
    }
    return new ($this->class)($this->container);
  }

  /**
   * Build the router.
   *
   * @throws \Xylemical\Router\Exception\RouterException
   * @throws \Xylemical\Router\Exception\InvalidDefinitionException
   */
  protected function doBuildRouter(): void {
    $compiler = new Compiler();
    $builder = new Builder($this->class, $this->source->load());
    $contents = $compiler->compile($builder->getDefinition());
    if (!@file_put_contents($this->filename, $contents)) {
      throw new RouterException("Unable to write to router file {$this->filename}.");
    }
  }

}
