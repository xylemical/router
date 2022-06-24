<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use function trim;

/**
 * Provides a route path definition.
 */
class Path implements \Stringable {

  /**
   * The path value.
   *
   * @var string
   */
  protected string $path;

  /**
   * The path segments.
   *
   * @var \Xylemical\Router\Definition\Segment[]
   */
  protected array $segments;

  /**
   * Path constructor.
   *
   * @param string $path
   *   The path.
   */
  public function __construct(string $path) {
    $this->path = '/' . trim($path, '/');
    $this->segments = array_map(function ($segment) {
      return new Segment($segment);
    }, explode('/', trim($this->path, '/')));
  }

  /**
   * Get the path.
   *
   * @return string
   *   The path.
   */
  public function getPath(): string {
    return $this->path;
  }

  /**
   * Get the segments.
   *
   * @return \Xylemical\Router\Definition\Segment[]
   *   The segments.
   */
  public function getSegments(): array {
    return $this->segments;
  }

  /**
   * Compares one path to another.
   *
   * @param \Xylemical\Router\Definition\Path $a
   *   The first path.
   * @param \Xylemical\Router\Definition\Path $b
   *   The second path.
   *
   * @return int
   *   Return value similar to strcmp.
   */
  public static function compare(Path $a, Path $b): int {
    if ($a->getPath() === $b->getPath()) {
      return 0;
    }

    $segments = $b->getSegments();
    foreach ($a->getSegments() as $index => $segment) {
      if (!isset($segments[$index])) {
        return -1;
      }

      if ($segment->getParameter()) {
        if (!$segments[$index]->getParameter()) {
          return 1;
        }
      }
      elseif ($segments[$index]->getParameter()) {
        return -1;
      }
      elseif ($value = strcmp($segment->getValue(), $segments[$index]->getValue())) {
        return $value;
      }
    }
    return 1;
  }

  /**
   * {@inheritdoc}
   */
  public function __toString(): string {
    return $this->path;
  }

}
