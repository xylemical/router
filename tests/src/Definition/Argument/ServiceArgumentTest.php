<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition\Argument;

use PHPUnit\Framework\TestCase;

/**
 * Tests \Xylemical\Router\Definition\Argument\ServiceArgument.
 */
class ServiceArgumentTest extends TestCase {

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $argument = new ServiceArgument(TestCase::class);
    $variables['container'] = '$this->container';

    $this->assertEquals(
      '$this->container->get(\'PHPUnit\Framework\TestCase\')',
      $argument->compile($variables)
    );
  }

}
