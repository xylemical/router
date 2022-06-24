<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * Tests \Xylemical\Router\Definition\Segment.
 */
class SegmentTest extends TestCase {

  use ProphecyTrait;

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $parameter = $this->prophesize(ParameterInterface::class);
    $parameter = $parameter->reveal();

    $segment = new Segment('value');
    $this->assertEquals('value', $segment->getValue());
    $this->assertEquals('value', (string) $segment);
    $this->assertNull($segment->getParameter());

    $segment->setParameter($parameter);
    $this->assertSame($parameter, $segment->getParameter());
  }

}
