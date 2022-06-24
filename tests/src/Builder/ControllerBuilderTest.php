<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Xylemical\Router\Definition\ControllerInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Tests \Xylemical\Router\Builder\ControllerBuilder.
 */
class ControllerBuilderTest extends TestCase {

  use ProphecyTrait;

  /**
   * Get a mock controller.
   *
   * @return \Xylemical\Router\Definition\ControllerInterface
   *   The controller.
   */
  protected function getMockController(): ControllerInterface {
    return $this->getMockBuilder(ControllerInterface::class)->getMock();
  }

  /**
   * Get a mock controller builder.
   *
   * @param \Xylemical\Router\Definition\ControllerInterface|null $controller
   *   The controller.
   *
   * @return \Xylemical\Router\Builder\ControllerBuilderInterface
   *   The mock controller builder.
   */
  protected function getMockControllerBuilder(?ControllerInterface $controller): ControllerBuilderInterface {
    $controllerBuilder = $this->prophesize(ControllerBuilderInterface::class);
    $controllerBuilder->build(Argument::any(), Argument::any(), Argument::any(), Argument::any())
      ->willReturn($controller);
    return $controllerBuilder->reveal();
  }

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $mockBuilder = $this->getMockBuilder(BuilderInterface::class)->getMock();
    $route = $this->getMockBuilder(RouteInterface::class)
      ->disableOriginalConstructor()
      ->getMock();

    $builder = new ControllerBuilder();
    $controller = $this->getMockController();
    $r1 = $this->getMockControllerBuilder(NULL);
    $r2 = $this->getMockControllerBuilder($controller);

    $builder->setBuilders([$r1]);
    $this->assertNotSame($controller, $builder->build('test', [], $route, $mockBuilder));

    $builder->addBuilder($r2);
    $this->assertSame($controller, $builder->build('test', [], $route, $mockBuilder));
  }

}
