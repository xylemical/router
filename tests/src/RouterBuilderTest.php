<?php

declare(strict_types=1);

namespace Xylemical\Router;

use App\Router;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;
use Xylemical\Router\Definition\Definition;
use Xylemical\Router\Definition\RouteDefinition;
use Xylemical\Router\Definition\SourceInterface;
use Xylemical\Router\Exception\RouterException;

/**
 * Tests \Xylemical\Router\RouterBuilder.
 */
class RouterBuilderTest extends TestCase {

  use ProphecyTrait;

  /**
   * The virtual file system.
   *
   * @var \org\bovigo\vfs\vfsStreamDirectory
   */
  protected vfsStreamDirectory $root;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    $this->root = vfsStream::setup();
  }

  /**
   * Create a mock source.
   *
   * @param array $routes
   *   The definition.
   * @param int $timestamp
   *   The timestamp.
   *
   * @return \Xylemical\Router\Definition\SourceInterface
   *   The source.
   */
  protected function getMockSource(array $routes, int $timestamp): SourceInterface {
    $source = $this->prophesize(SourceInterface::class);
    $source->getClass()->willReturn(Definition::class);
    $source->getTimestamp()->willReturn($timestamp);
    $source->getRoutes()->willReturn($routes);
    $source->getRouteBuilders()->willReturn([]);
    $source->getArgumentBuilders()->willReturn([]);
    $source->getParameterBuilders()->willReturn([]);
    $source->getControllerBuilders()->willReturn([]);
    $source->getModifiers()->willReturn([]);
    $source->load()->will(function () {
      return $this;
    });
    return $source->reveal();
  }

  /**
   * Tests the sanity of the router build.
   */
  public function testSanity(): void {
    $container = $this->getMockBuilder(ContainerInterface::class)->getMock();

    /* @phpstan-ignore-next-line */
    $class = Router::class;
    $filename = "{$this->root->url()}/router.php";

    $definition = [];
    $source = $this->getMockSource($definition, time());

    $builder = new RouterBuilder($container, $source, $filename, $class);
    $router = $builder->getRouter();

    $expected = file_get_contents(__DIR__ . '/../fixtures/TestSanity.php');
    $this->assertEquals($expected, file_get_contents($filename));
    $this->assertInstanceOf($class, $router);

    $definition = [
      (new RouteDefinition('r1', [
        'class' => 'App\\Route',
        'path' => '/',
        'methods' => ['POST'],
      ])),
      (new RouteDefinition('r2', [
        'path' => '/admin/config',
        'methods' => ['GET'],
      ])),
      (new RouteDefinition('r3', [
        'path' => '/admin/{user}',
        'parameters' => [
          'user' => [
            'regex' => '\w+',
          ],
        ],
      ])),
      (new RouteDefinition('r4', [
        'path' => '/{id}/{token}',
        'parameters' => [
          'id' => [
            'regex' => '\d+',
          ],
          'token' => [
            'regex' => '\d+',
          ],
        ],
        'controller' => [
          'callable' => 'this',
        ],
      ])),
      (new RouteDefinition('r5', [
        'path' => '/admin/config',
        'controller' => [
          'class' => 'App\\ControllerDefinition',
          'callable' => 'App\\Controller::get',
        ],
      ])),
      (new RouteDefinition('r6', [
        'path' => '/!type/content',
        'controller' => [
          'callable' => 'App\\Controller::get',
        ],
        'arguments' => [
          '@App\\Service',
          1,
          '%OMG:FOO%',
        ],
      ])),
    ];

    $source = $this->getMockSource($definition, time() - 100);

    $builder = new RouterBuilder($container, $source, $filename, $class);
    $router = $builder->getRouter();

    $expected = file_get_contents(__DIR__ . '/../fixtures/TestSanity.php');
    $this->assertEquals($expected, file_get_contents($filename));
    $this->assertInstanceOf($class, $router);

    $source = $this->getMockSource($definition, time() + 100);

    $builder = new RouterBuilder($container, $source, $filename, $class);
    $router = $builder->getRouter();

    $expected = file_get_contents(__DIR__ . '/../fixtures/TestCompilation.php');
    $this->assertEquals($expected, file_get_contents($filename));
    $this->assertInstanceOf($class, $router);
  }

  /**
   * Tests write failure.
   */
  public function testWriteFailure(): void {
    $container = $this->getMockBuilder(ContainerInterface::class)->getMock();

    $class = 'App\\Router';
    $filename = "{$this->root->url()}/router.php";

    $definition = [];
    $source = $this->getMockSource($definition, time());
    $builder = new RouterBuilder($container, $source, $filename, $class);
    $builder->getRouter();

    chmod($filename, 0400);

    $this->expectException(RouterException::class);
    $source = $this->getMockSource($definition, time() + 100);
    $builder = new RouterBuilder($container, $source, $filename, $class);
    $builder->getRouter();
  }

}
