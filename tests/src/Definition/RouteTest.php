<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use PHPUnit\Framework\TestCase;
use Xylemical\Router\Route as DefaultRoute;

/**
 * Tests \Xylemical\Router\Definition\Route.
 */
class RouteTest extends TestCase {

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $route = new Route('test', '/foo');
    $this->assertEquals('test', $route->getName());
    $this->assertEquals('/foo', (string) $route->getPath());
    $this->assertEquals(DefaultRoute::class, $route->getClass());
    $this->assertEquals([], $route->getMethods());
    $this->assertFalse($route->hasMethod('GET'));
    $this->assertEquals([], $route->getParameters());
    $this->assertNull($route->getController());
    $this->assertEquals(
      <<<EOF
\$route = new \Xylemical\Router\Route(\$route_name, \$parameters);
\$route->setRequest(\$this->request);
\$route->setController(NULL);
return \$route;

EOF
,
      $route->compile()
    );

    $route->addMethod('GET');
    $this->assertEquals(['GET'], $route->getMethods());
    $this->assertTrue($route->hasMethod('GET'));
    $this->assertFalse($route->hasMethod('POST'));

    $route->removeMethod('GET');
    $this->assertEquals([], $route->getMethods());
    $this->assertFalse($route->hasMethod('GET'));
  }

}
