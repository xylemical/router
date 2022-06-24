<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use PHPUnit\Framework\TestCase;
use Xylemical\Router\TestCallable;

/**
 * Tests \Xylemical\Router\Definition\Controller.
 */
class ControllerTest extends TestCase {

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $variables = [];
    $controller = new Controller(Controller::class, TestCase::class, 'testSanity', []);
    $this->assertEquals(
      <<<EOF
new \Xylemical\Router\Definition\Controller(
  'PHPUnit\Framework\TestCase',
  'testSanity',
  []
)

EOF
      ,
      $controller->compile($variables)
    );

    $arguments = [new Argument(['foo' => 'bar'])];
    $controller = new Controller(Controller::class, TestCase::class, 'testSanity', $arguments);
    $this->assertEquals(
      <<<EOF
new \Xylemical\Router\Definition\Controller(
  'PHPUnit\Framework\TestCase',
  'testSanity',
  [
    [
  'foo' => 'bar',
],
  ]
)

EOF
      ,
      $controller->compile($variables)
    );

    $this->assertEquals(Controller::class, $controller->getClass());
    $this->assertEquals(TestCase::class, $controller->getController());
    $this->assertEquals('testSanity', $controller->getMethod());
    $this->assertEquals([new Argument(['foo' => 'bar'])], $controller->getArguments());

    $controller->setClass(TestCallable::class);
    $this->assertEquals(TestCallable::class, $controller->getClass());
    $controller->setController(TestCallable::class);
    $this->assertEquals(TestCallable::class, $controller->getController());
    $controller->setMethod('s');
    $this->assertEquals('s', $controller->getMethod());
    $controller->setArguments([new Argument(['bar' => 'baz'])]);
    $this->assertEquals([new Argument(['bar' => 'baz'])], $controller->getArguments());
  }

}
