<?php

declare(strict_types=1);

namespace Xylemical\Router\Compiler;

use PHPUnit\Framework\TestCase;
use Xylemical\Router\Controller as DefaultController;
use Xylemical\Router\Definition\Argument;
use Xylemical\Router\Definition\Argument\ServiceArgument;
use Xylemical\Router\Definition\Controller;
use Xylemical\Router\Definition\Definition;
use Xylemical\Router\Definition\Parameter;
use Xylemical\Router\Definition\Route;
use function file_get_contents;
use Xylemical\Router\Definition\Argument\EnvironmentArgument;

/**
 * Tests \Xylemical\Router\Compiler\Compiler.
 */
class CompilerTest extends TestCase {

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $definition = new Definition('\\App\\Router');

    $compiler = new Compiler();

    $contents = file_get_contents(__DIR__ . '/../../fixtures/TestSanity.php');
    $this->assertEquals($contents, $compiler->compile($definition));
  }

  /**
   * Tests compilation.
   */
  public function testCompilation(): void {
    $definition = new Definition('\\App\\Router');
    $definition->addRoutes([
      (new Route('r1', '/'))
        ->setClass('App\\Route')
        ->addMethod('POST'),
      (new Route('r2', '/admin/config'))
        ->addMethod('GET'),
      (new Route('r3', '/admin/{user}'))
        ->setParameter(1, new Parameter('user', '\w+')),
      (new Route('r4', '/{id}/{token}'))
        ->setParameter(0, new Parameter('id', '\d+'))
        ->setParameter(1, new Parameter('token', '\d+')),
      (new Route('r5', '/admin/config'))
        ->setController(
          new Controller(
            'App\ControllerDefinition',
            'App\\Controller',
            'get',
            []
          )
      ),
      (new Route('r6', '/{type}/content'))
        ->setParameter(0, new Parameter('type', '.*?'))
        ->setController(
          new Controller(
            DefaultController::class,
            'App\\Controller',
            'get',
            [
              new ServiceArgument('App\\Service'),
              new Argument(1),
              new EnvironmentArgument('OMG', 'FOO'),
            ]
          )
      ),
    ]);

    $compiler = new Compiler();

    $contents = file_get_contents(__DIR__ . '/../../fixtures/TestCompilation.php');
    $this->assertEquals($contents, $compiler->compile($definition));
  }

}
