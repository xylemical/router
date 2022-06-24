<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

/**
 * Provides modification of the sources before creating the definition.
 */
interface ModifierInterface {

  /**
   * ModifierInterface constructor.
   */
  public function __construct();

  /**
   * Get the priority of the modifier.
   *
   * @return int
   *   The priority.
   */
  public function getPriority(): int;

  /**
   * Apply modification to the source.
   *
   * @param \Xylemical\Router\Definition\Source $source
   *   The source.
   */
  public function apply(Source $source): void;

}
