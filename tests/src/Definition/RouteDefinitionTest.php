<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use PHPUnit\Framework\TestCase;

/**
 * Tests \Xylemical\Router\Definition\RouteDefinition.
 */
class RouteDefinitionTest extends TestCase {

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $definition = new RouteDefinition('test');
    $this->assertEquals('test', $definition->getName());
    $this->assertEquals('', $definition->getPath());
    $this->assertEquals([], $definition->getMethods());
    $this->assertEquals([], $definition->getParameters());
    $this->assertEquals([], $definition->getParameter('a'));
    $this->assertEquals([], $definition->getController());

    $definition = new RouteDefinition('foo', [
      'path' => '/admin',
      'methods' => ['GET'],
      'parameters' => ['a' => ['regex' => TRUE]],
      'controller' => [
        'callable' => 'Controller::class',
      ],
    ]);
    $this->assertEquals('foo', $definition->getName());
    $this->assertEquals('/admin', $definition->getPath());
    $this->assertEquals(['GET'], $definition->getMethods());
    $this->assertEquals(['a' => ['regex' => TRUE]], $definition->getParameters());
    $this->assertEquals(['regex' => TRUE], $definition->getParameter('a'));
    $this->assertEquals(['callable' => 'Controller::class'], $definition->getController());

    $definition->setMethods(['POST']);
    $this->assertEquals(['POST'], $definition->getMethods());

    $definition->setParameters(['b' => ['regex' => TRUE]]);
    $this->assertEquals(['b' => ['regex' => TRUE]], $definition->getParameters());
    $this->assertEquals(['regex' => TRUE], $definition->getParameter('b'));
  }

}
