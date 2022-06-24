<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Xylemical\Router\Definition\ArgumentInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Tests \Xylemical\Router\Builder\ArgumentBuilder.
 */
class ArgumentBuilderTest extends TestCase {

  use ProphecyTrait;

  /**
   * Get a mock argument.
   *
   * @return \Xylemical\Router\Definition\ArgumentInterface
   *   The argument.
   */
  protected function getMockArgument(): ArgumentInterface {
    return $this->getMockBuilder(ArgumentInterface::class)->getMock();
  }

  /**
   * Get a mock argument builder.
   *
   * @param \Xylemical\Router\Definition\ArgumentInterface|null $argument
   *   The argument.
   *
   * @return \Xylemical\Router\Builder\ArgumentBuilderInterface
   *   The mock argument builder.
   */
  protected function getMockArgumentBuilder(?ArgumentInterface $argument): ArgumentBuilderInterface {
    $argumentBuilder = $this->prophesize(ArgumentBuilderInterface::class);
    $argumentBuilder->build(Argument::any(), Argument::any(), Argument::any())
      ->willReturn($argument);
    return $argumentBuilder->reveal();
  }

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $mockBuilder = $this->getMockBuilder(BuilderInterface::class)->getMock();
    $route = $this->getMockBuilder(RouteInterface::class)
      ->disableOriginalConstructor()
      ->getMock();

    $builder = new ArgumentBuilder();
    $argument = $this->getMockArgument();
    $r1 = $this->getMockArgumentBuilder(NULL);
    $r2 = $this->getMockArgumentBuilder($argument);

    $builder->setBuilders([$r1]);
    $this->assertNotSame($argument, $builder->build([], $route, $mockBuilder));

    $builder->addBuilder($r2);
    $this->assertSame($argument, $builder->build([], $route, $mockBuilder));
  }

}
