<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use PHPUnit\Framework\TestCase;
use Xylemical\Router\Builder\ArgumentBuilderInterface;
use Xylemical\Router\Builder\ControllerBuilderInterface;
use Xylemical\Router\Builder\ParameterBuilder;
use Xylemical\Router\Builder\ParameterBuilderInterface;
use Xylemical\Router\Builder\RouteBuilderInterface;

/**
 * Tests \Xylemical\Router\Source\Source.
 */
class SourceTest extends TestCase {

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $timestamp = time();

    $source = new Source();
    $this->assertEquals(Definition::class, $source->getClass());
    $this->assertEquals([], $source->getRoutes());
    $this->assertNull($source->getRoute(SourceInterface::class));
    $this->assertFalse($source->hasRoute(SourceInterface::class));
    $this->assertEquals([], $source->getRouteBuilders());
    $this->assertEquals([], $source->getArgumentBuilders());
    $this->assertEquals([], $source->getParameterBuilders());
    $this->assertEquals([], $source->getControllerBuilders());
    $this->assertEquals($timestamp, $source->getTimestamp());

    $source->load();

    $this->assertEquals(Definition::class, $source->getClass());
    $this->assertEquals([], $source->getRoutes());
    $this->assertNull($source->getRoute(SourceInterface::class));
    $this->assertFalse($source->hasRoute(SourceInterface::class));
    $this->assertEquals([], $source->getRouteBuilders());
    $this->assertEquals([], $source->getArgumentBuilders());
    $this->assertEquals([], $source->getParameterBuilders());
    $this->assertEquals([], $source->getControllerBuilders());
    $this->assertEquals($timestamp, $source->getTimestamp());

    $argumentBuilder = ArgumentBuilderInterface::class;
    $routeBuilder = RouteBuilderInterface::class;
    $parameterBuilder = ParameterBuilderInterface::class;
    $controllerBuilder = ControllerBuilderInterface::class;

    $route = new RouteDefinition(SourceInterface::class);
    $source
      ->setClass(TestDefinition::class)
      ->setRoute($route)
      ->setRouteBuilders([$routeBuilder])
      ->setArgumentBuilders([$argumentBuilder])
      ->setParameterBuilders([$parameterBuilder])
      ->setControllerBuilders([$controllerBuilder])
      ->setTimestamp($timestamp + 100);

    $copy = new Source($source);
    $this->assertEquals($source->getClass(), $copy->getClass());
    $this->assertEquals($source->getArgumentBuilders(), $copy->getArgumentBuilders());
    $this->assertEquals($source->getParameterBuilders(), $copy->getParameterBuilders());
    $this->assertEquals($source->getRouteBuilders(), $copy->getRouteBuilders());
    $this->assertEquals($source->getControllerBuilders(), $copy->getControllerBuilders());
    $this->assertEquals($source->getRoute(SourceInterface::class), $copy->getRoute(SourceInterface::class));
    $this->assertNotSame($source->getRoute(SourceInterface::class), $copy->getRoute(SourceInterface::class));
    $this->assertEquals($source->getTimestamp(), $copy->getTimestamp());

    $this->assertEquals(TestDefinition::class, $source->getClass());
    $this->assertEquals([SourceInterface::class => $route], $source->getRoutes());
    $this->assertSame($route, $source->getRoute(SourceInterface::class));
    $this->assertTrue($source->hasRoute(SourceInterface::class));
    $this->assertEquals([$routeBuilder], $source->getRouteBuilders());
    $this->assertTrue($source->hasRouteBuilder(RouteBuilderInterface::class));
    $this->assertFalse($source->hasRouteBuilder(ArgumentBuilderInterface::class));
    $source->removeRouteBuilder(RouteBuilderInterface::class);
    $this->assertFalse($source->hasRouteBuilder(RouteBuilderInterface::class));
    $this->assertEquals([$argumentBuilder], $source->getArgumentBuilders());
    $this->assertTrue($source->hasArgumentBuilder(ArgumentBuilderInterface::class));
    $this->assertFalse($source->hasArgumentBuilder(RouteBuilderInterface::class));
    $source->removeArgumentBuilder(ArgumentBuilderInterface::class);
    $this->assertFalse($source->hasArgumentBuilder(ArgumentBuilderInterface::class));
    $this->assertEquals([$parameterBuilder], $source->getParameterBuilders());
    $this->assertTrue($source->hasParameterBuilder(ParameterBuilderInterface::class));
    $this->assertFalse($source->hasParameterBuilder(RouteBuilderInterface::class));
    $source->removeParameterBuilder(ParameterBuilderInterface::class);
    $this->assertFalse($source->hasParameterBuilder(ParameterBuilderInterface::class));
    $this->assertEquals([$controllerBuilder], $source->getControllerBuilders());
    $this->assertTrue($source->hasControllerBuilder(ControllerBuilderInterface::class));
    $this->assertFalse($source->hasControllerBuilder(RouteBuilderInterface::class));
    $source->removeControllerBuilder(ControllerBuilderInterface::class);
    $this->assertFalse($source->hasControllerBuilder(ControllerBuilderInterface::class));

    $this->assertEquals($timestamp + 100, $source->getTimestamp());

    $source->setTimestamp(NULL);
    $this->assertEquals(time(), $source->getTimestamp());

  }

  /**
   * Tests load process.
   */
  public function testLoad(): void {
    $source = (new TestSource)->load();
    $this->assertTrue($source->hasRoute(SourceInterface::class));
    $this->assertFalse($source->hasParameterBuilder(ParameterBuilder::class));
    $route = $source->getRoute(SourceInterface::class);
  }

}
