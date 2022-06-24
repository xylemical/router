<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Xylemical\Router\Definition\ParameterInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Tests \Xylemical\Router\Builder\ParameterBuilder.
 */
class ParameterBuilderTest extends TestCase {

  use ProphecyTrait;

  /**
   * Get a mock parameter.
   *
   * @return \Xylemical\Router\Definition\ParameterInterface
   *   The parameter.
   */
  protected function getMockParameter(): ParameterInterface {
    return $this->getMockBuilder(ParameterInterface::class)->getMock();
  }

  /**
   * Get a mock parameter builder.
   *
   * @param \Xylemical\Router\Definition\ParameterInterface|null $parameter
   *   The parameter.
   *
   * @return \Xylemical\Router\Builder\ParameterBuilderInterface
   *   The mock parameter builder.
   */
  protected function getMockParameterBuilder(?ParameterInterface $parameter): ParameterBuilderInterface {
    $parameterBuilder = $this->prophesize(ParameterBuilderInterface::class);
    $parameterBuilder->build(Argument::any(), Argument::any(), Argument::any(), Argument::any())
      ->willReturn($parameter);
    return $parameterBuilder->reveal();
  }

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $mockBuilder = $this->getMockBuilder(BuilderInterface::class)->getMock();
    $route = $this->getMockBuilder(RouteInterface::class)
      ->disableOriginalConstructor()
      ->getMock();

    $builder = new ParameterBuilder();
    $parameter = $this->getMockParameter();
    $r1 = $this->getMockParameterBuilder(NULL);
    $r2 = $this->getMockParameterBuilder($parameter);

    $builder->setBuilders([$r1]);
    $this->assertNotSame($parameter, $builder->build('test', [], $route, $mockBuilder));

    $builder->addBuilder($r2);
    $this->assertSame($parameter, $builder->build('test', [], $route, $mockBuilder));
  }

}
