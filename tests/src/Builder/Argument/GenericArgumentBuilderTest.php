<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder\Argument;

use PHPUnit\Framework\TestCase;
use Xylemical\Router\Builder\BuilderInterface;
use Xylemical\Router\Definition\RouteInterface;

/**
 * Tests \Xylemical\Router\Builder\Argument\GenericArgumentBuilder.
 */
class GenericArgumentBuilderTest extends TestCase {

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $builder = $this->getMockBuilder(BuilderInterface::class)->getMock();
    $route = $this->getMockBuilder(RouteInterface::class)
      ->disableOriginalConstructor()
      ->getMock();

    $argument = new GenericArgumentBuilder();
    $result = $argument->build('test', $route, $builder);
    $variables = [];
    $this->assertEquals("'test'", $result->compile($variables));
  }

}
