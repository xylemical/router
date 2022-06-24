<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use PHPUnit\Framework\TestCase;

/**
 * Tests \Xylemical\Router\Definition\Argument.
 */
class ArgumentTest extends TestCase {

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $variables = [];
    $argument = new Argument(NULL);
    $this->assertEquals('NULL', $argument->compile($variables));
  }

}
