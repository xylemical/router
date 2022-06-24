<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use PHPUnit\Framework\TestCase;

/**
 * Tests \Xylemical\Router\Definition\Path.
 */
class PathTest extends TestCase {

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $path = new Path('/admin');
    $this->assertEquals('/admin', $path->getPath());
    $this->assertEquals([new Segment('admin')], $path->getSegments());

    $path = new Path('admin');
    $this->assertEquals('/admin', $path->getPath());
    $this->assertEquals([new Segment('admin')], $path->getSegments());

    $path = new Path('/admin/{user}');
    $this->assertEquals('/admin/{user}', $path->getPath());
    $this->assertEquals([
      new Segment('admin'),
      new Segment('{user}'),
    ], $path->getSegments());
  }

  /**
   * Provides test data for testCompare().
   *
   * @return array
   *   The test data.
   */
  public function providerTestCompare(): array {
    return [
      ['', '/', 0],
      ['/', '/', 0],
      ['/', '', 0],
      ['admin', '/admin', 0],
      ['/admin', '/admin', 0],
      ['/admin', 'admin', 0],
      ['/admin/{user}', '/admin/{cricket}', 1],
      ['/admin/{cricket}', '/admin/{user}', -1],
      ['/admin/{user}', '/admin/{user}/config', 1],
      ['/admin/{user}/config', '/admin/{user}', -1],
    ];
  }

  /**
   * Tests compare.
   *
   * @dataProvider providerTestCompare
   */
  public function testCompare(string $a, string $b, int $result): void {
    $this->assertEquals($result, Path::compare(new Path($a), new Path($b)));
  }

}
