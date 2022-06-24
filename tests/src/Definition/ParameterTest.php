<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use PHPUnit\Framework\TestCase;

/**
 * Tests \Xylemical\Router\Definition\Parameter.
 */
class ParameterTest extends TestCase {

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $parameter = new Parameter('test', '.*?');
    $this->assertEquals('test', $parameter->getName());
    $this->assertEquals('.*?', $parameter->getRegex());
    $variables = ['parameters' => '$rosy', 'parameter' => 1];
    $this->assertEquals('$rosy[1]', $parameter->compile($variables));
  }

}
