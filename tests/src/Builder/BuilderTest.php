<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use App\Router;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Xylemical\Router\Definition\Argument as DefaultArgument;
use Xylemical\Router\Definition\Argument\EnvironmentArgument;
use Xylemical\Router\Definition\Argument\ServiceArgument;
use Xylemical\Router\Definition\ArgumentInterface;
use Xylemical\Router\Definition\Controller;
use Xylemical\Router\Definition\Definition;
use Xylemical\Router\Definition\Parameter;
use Xylemical\Router\Definition\ParameterInterface;
use Xylemical\Router\Definition\RouteDefinition;
use Xylemical\Router\Definition\SourceInterface;
use Xylemical\Router\Definition\TestDefinition;
use Xylemical\Router\Definition\TestModifier;
use Xylemical\Router\Exception\InvalidDefinitionException;
use Xylemical\Router\Route;
use Xylemical\Router\TestRouter;

/**
 * Tests \Xylemical\Router\Builder\Builder.
 */
class BuilderTest extends TestCase {

  use ProphecyTrait;

  /**
   * Get a mock argument builder.
   *
   * @param mixed $definition
   *   The definition.
   * @param \Xylemical\Router\Definition\ArgumentInterface|null $argument
   *   The return argument.
   *
   * @return \Xylemical\Router\Builder\ArgumentBuilderInterface
   *   The mocked builder.
   */
  protected function getMockArgumentBuilder(mixed $definition, ?ArgumentInterface $argument): ArgumentBuilderInterface {
    $builder = $this->prophesize(ArgumentBuilderInterface::class);
    $builder->build($definition, Argument::any(), Argument::any())
      ->willReturn($argument);
    return $builder->reveal();
  }

  /**
   * Get a mock parameter builder.
   *
   * @param mixed $definition
   *   The definition.
   * @param \Xylemical\Router\Definition\ParameterInterface|null $parameter
   *   The return parameter.
   *
   * @return \Xylemical\Router\Builder\ParameterBuilderInterface
   *   The mocked parameter builder.
   */
  protected function getMockParameterBuilder(mixed $definition, ?ParameterInterface $parameter): ParameterBuilderInterface {
    $builder = $this->prophesize(ParameterBuilderInterface::class);
    $builder->build(Argument::any(), $definition, Argument::any(), Argument::any())
      ->willReturn($parameter);
    return $builder->reveal();
  }

  /**
   * Creates a mock source.
   *
   * @param bool $custom
   *   The source is customized.
   *
   * @return \Xylemical\Router\Definition\SourceInterface
   *   The source.
   */
  protected function getMockSource(bool $custom = FALSE): SourceInterface {
    $definition = (new RouteDefinition('r1'))
      ->setPath('/admin/{test}')
      ->setClass('App\\Route')
      ->setController([
        'callable' => Controller::class . '::get',
      ])
      ->setArguments([
        '%OMG:default%',
        '%FOO%',
        '@source',
        10,
        'something shocking',
      ])
      ->setParameter('test', ['regex' => '\w+'])
      ->setParameter('none', ['regex' => '\d+']);

    $source = $this->prophesize(SourceInterface::class);
    $source->getClass()
      ->willReturn($custom ? TestDefinition::class : Definition::class);
    $source->getRoutes()->willReturn([$definition]);
    if ($custom) {
      $source->getRouteBuilders()->willReturn([TestRouteBuilder::class]);
      $source->getArgumentBuilders()->willReturn([TestArgumentBuilder::class]);
      $source->getParameterBuilders()
        ->willReturn([TestParameterBuilder::class]);
      $source->getControllerBuilders()
        ->willReturn([TestControllerBuilder::class]);
      $source->getModifiers()->willReturn([TestModifier::class]);
    }
    else {
      $source->getRouteBuilders()->willReturn([]);
      $source->getArgumentBuilders()->willReturn([]);
      $source->getParameterBuilders()->willReturn([]);
      $source->getControllerBuilders()->willReturn([]);
      $source->getModifiers()->willReturn([]);
    }
    $source->getTimestamp()->willReturn(0);
    return $source->reveal();

  }

  /**
   * Tests sanity.
   */
  public function testSanity(): void {
    $source = $this->getMockSource();
    // @phpstan-ignore-next-line
    $builder = new Builder(Router::class, $source);

    $definition = $builder->getDefinition();
    $this->assertInstanceOf(Definition::class, $definition);
    // @phpstan-ignore-next-line
    $this->assertEquals(Router::class, $definition->getClass());

    $route = $definition->getRoute('r1');
    $this->assertNotNull($route);
    $this->assertEquals('r1', $route->getName());
    $this->assertEquals('App\\Route', $route->getClass());
    $controller = $route->getController();
    $this->assertInstanceOf(Controller::class, $controller);
    // @phpstan-ignore-next-line
    $arguments = $controller->getArguments();
    $this->assertEquals(5, count($arguments));
    $this->assertInstanceOf(EnvironmentArgument::class, $arguments[0]);
    $this->assertInstanceOf(EnvironmentArgument::class, $arguments[1]);
    $this->assertInstanceOf(ServiceArgument::class, $arguments[2]);
    $this->assertInstanceOf(DefaultArgument::class, $arguments[3]);
    $this->assertInstanceOf(DefaultArgument::class, $arguments[4]);
    $parameters = $route->getParameters();
    $this->assertEquals(1, count($parameters));
    $this->assertInstanceOf(Parameter::class, $parameters[0]);
  }

  /**
   * Tests the source builder overrides.
   */
  public function testSourceBuilders(): void {
    $source = $this->getMockSource(TRUE);
    $builder = new Builder(TestRouter::class, $source);

    $definition = $builder->getDefinition();
    $this->assertEquals(TestRouter::class, $definition->getClass());
  }

  /**
   * Tests that an invalid source definition class raises an exception.
   */
  public function testInvalidDefinition(): void {
    $source = $this->prophesize(SourceInterface::class);
    $source->getClass()->willReturn(Route::class);
    $source->getRoutes()->willReturn([]);
    $source->getRouteBuilders()->willReturn([]);
    $source->getArgumentBuilders()->willReturn([]);
    $source->getParameterBuilders()->willReturn([]);
    $source->getControllerBuilders()->willReturn([]);
    $source->getModifiers()->willReturn([]);
    $source->getTimestamp()->willReturn(0);

    // @phpstan-ignore-next-line
    $builder = new Builder(Router::class, $source->reveal());

    $this->expectException(InvalidDefinitionException::class);
    $builder->getDefinition();
  }

}
