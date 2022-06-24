<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use PHPUnit\Framework\TestCase;

/**
 * Tests \Xylemical\Router\Definition\Definition.
 */
class DefinitionTest extends TestCase {

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $route = new Route('test', '/admin');
    $definition = new Definition(Definition::class, [
      $route,
    ]);
    $this->assertEquals(Definition::class, $definition->getClass());
    $this->assertEquals(['test' => $route], $definition->getRoutes());
    $this->assertSame($route, $definition->getRoute('test'));

    $definition->setRoutes([]);
    $this->assertEquals([], $definition->getRoutes());
    $this->assertNull($definition->getRoute('test'));

    $definition->addRoute($route);
    $this->assertSame($route, $definition->getRoute('test'));
    $definition->removeRoute('test');
    $this->assertNull($definition->getRoute('test'));
  }

}
