<?php

declare(strict_types=1);

namespace Xylemical\Router;

use PHPUnit\Framework\TestCase;

/**
 * Tests \Xylemical\Router\Controller.
 */
class ControllerTest extends TestCase {

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $callable = new TestCallable();
    $controller = new Controller($callable, 'call', ['b']);
    $this->assertEquals(['b'], $controller->getArguments());
    $this->assertEquals('bbc', $controller());
    $this->assertEquals('bde', $controller('d', 'e', 'f'));
  }

}
