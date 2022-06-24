<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Xylemical\Router\Definition\RouteDefinition;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Tests \Xylemical\Router\Builder\RouteBuilder.
 */
class RouteBuilderTest extends TestCase {

  use ProphecyTrait;

  /**
   * Get a mock route.
   *
   * @return \Xylemical\Router\Definition\RouteInterface
   *   The route.
   */
  protected function getMockRoute(): RouteInterface {
    return $this->getMockBuilder(RouteInterface::class)
      ->disableOriginalConstructor()
      ->getMock();
  }

  /**
   * Get a mock route builder.
   *
   * @param \Xylemical\Router\Definition\RouteInterface|null $route
   *   The route.
   *
   * @return \Xylemical\Router\Builder\RouteBuilderInterface
   *   The mock route builder.
   */
  protected function getMockRouteBuilder(?RouteInterface $route): RouteBuilderInterface {
    $routeBuilder = $this->prophesize(RouteBuilderInterface::class);
    $routeBuilder->build(Argument::any(), Argument::any())
      ->willReturn($route);
    return $routeBuilder->reveal();
  }

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $mockBuilder = $this->getMockBuilder(BuilderInterface::class)->getMock();
    $definition = $this->getMockBuilder(RouteDefinition::class)
      ->disableOriginalConstructor()
      ->getMock();

    $builder = new RouteBuilder();
    $route = $this->getMockRoute();
    $r1 = $this->getMockRouteBuilder(NULL);
    $r2 = $this->getMockRouteBuilder($route);

    $builder->setBuilders([$r1]);
    $this->assertNotSame($route, $builder->build($definition, $mockBuilder));

    $builder->addBuilder($r2);
    $this->assertSame($route, $builder->build($definition, $mockBuilder));
  }

}
