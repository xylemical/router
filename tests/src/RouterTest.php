<?php

declare(strict_types=1);

namespace Xylemical\Router;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Tests \Xylemical\Router\Router.
 */
class RouterTest extends TestCase {

  use ProphecyTrait;

  /**
   * Create mock container.
   *
   * @param array $services
   *   The services of the container.
   *
   * @return \Psr\Container\ContainerInterface
   *   The container.
   */
  protected function getMockContainer(array $services): ContainerInterface {
    $container = $this->prophesize(ContainerInterface::class);
    foreach ($services as $name => $service) {
      $container->has($name)->willReturn(TRUE);
      $container->get($name)->willReturn($service);
    }
    $container->has(Argument::any())->willReturn(FALSE);
    return $container->reveal();
  }

  /**
   * Get a mock server request.
   *
   * @param string $path
   *   The path.
   * @param string $method
   *   The method.
   *
   * @return \Psr\Http\Message\ServerRequestInterface
   *   The request.
   */
  protected function getMockRequest(string $path, string $method): ServerRequestInterface {
    $request = $this->prophesize(ServerRequestInterface::class);
    $request->getRequestTarget()->willReturn($path);
    $request->getMethod()->willReturn($method);
    return $request->reveal();
  }

  /**
   * Test sanity.
   */
  public function testSanity(): void {
    $dummy = new \stdClass();
    $container = $this->getMockContainer([
      'controller' => $dummy,
    ]);
    $router = new TestRouter($container);

    $request = $this->getMockRequest('/', 'POST');
    $route = $router->match($request);
    $this->assertNotNull($route);
    $this->assertEquals('r1', $route->getName());
    $this->assertEquals([], $route->getParameters());
    $this->assertSame($request, $route->getRequest());
    $this->assertNotNull($route->getController());

    // @phpstan-ignore-next-line
    $this->assertSame($dummy, $route->getController()->getController());
    // @phpstan-ignore-next-line
    $this->assertEquals('', $route->getController()->getMethod());

    $request = $this->getMockRequest('/', 'GET');
    $route = $router->match($request);
    $this->assertNull($route);

    $request = $this->getMockRequest('/admin/config', 'GET');
    $route = $router->match($request);
    $this->assertNotNull($route);
    $this->assertEquals('r2', $route->getName());
    $this->assertEquals([], $route->getParameters());
    $this->assertSame($request, $route->getRequest());
    $this->assertNotNull($route->getController());

    $request = $this->getMockRequest('/admin/config', 'POST');
    $route = $router->match($request);
    $this->assertNotNull($route);
    $this->assertEquals('r5', $route->getName());
    $this->assertEquals([], $route->getParameters());
    $this->assertSame($request, $route->getRequest());
    $this->assertNotNull($route->getController());

    $request = $this->getMockRequest('/admin/test', 'GET');
    $route = $router->match($request);
    $this->assertNotNull($route);
    $this->assertEquals('r3', $route->getName());
    $this->assertEquals(['test'], $route->getParameters());
    $this->assertSame($request, $route->getRequest());
    $this->assertNotNull($route->getController());

    $request = $this->getMockRequest('/123/456', 'GET');
    $route = $router->match($request);
    $this->assertNotNull($route);
    $this->assertEquals('r4', $route->getName());
    $this->assertEquals(['123', '456'], $route->getParameters());
    $this->assertSame($request, $route->getRequest());
    $this->assertNotNull($route->getController());

    $request = $this->getMockRequest('/test/content', 'GET');
    $route = $router->match($request);
    $this->assertNotNull($route);
    $this->assertEquals('r6', $route->getName());
    $this->assertEquals(['test'], $route->getParameters());
    $this->assertSame($request, $route->getRequest());
    $this->assertNotNull($route->getController());

    $request = $this->getMockRequest('/test/foo', 'GET');
    $route = $router->match($request);
    $this->assertNull($route);
  }

}
