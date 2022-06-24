<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

/**
 * A test source.
 */
class TestSource extends Source {

  /**
   * {@inheritdoc}
   */
  protected function doLoad(): array {
    return [
      'modifiers' => [],
      'routes' => [
        SourceInterface::class => [
          'class' => Source::class,
          'tags' => ['test', ['name' => 'foo']],
        ],
      ],
    ];
  }

}
