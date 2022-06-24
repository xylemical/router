<?php

declare(strict_types=1);

namespace Xylemical\Router\Builder;

use Xylemical\Router\Builder\Argument\EnvironmentArgumentBuilder;
use Xylemical\Router\Builder\Argument\ServiceArgumentBuilder;
use Xylemical\Router\Builder\Parameter\PathParameterBuilder;
use Xylemical\Router\Definition\ArgumentInterface;
use Xylemical\Router\Definition\ControllerInterface;
use Xylemical\Router\Definition\DefinitionInterface;
use Xylemical\Router\Definition\Modifier;
use Xylemical\Router\Definition\ParameterInterface;
use Xylemical\Router\Definition\RouteDefinition;
use Xylemical\Router\Definition\RouteInterface;
use Xylemical\Router\Definition\Source;
use Xylemical\Router\Definition\SourceInterface;
use Xylemical\Router\Exception\InvalidDefinitionException;
use function array_map;

/**
 * Provides a builder for a definition.
 */
class Builder implements BuilderInterface {

  /**
   * The router class name.
   *
   * @var string
   */
  protected string $class;

  /**
   * Get the source.
   *
   * @var \Xylemical\Router\Definition\SourceInterface
   */
  protected SourceInterface $source;

  /**
   * The route builder.
   *
   * @var \Xylemical\Router\Builder\RouteBuilder
   */
  protected RouteBuilder $routeBuilder;

  /**
   * The argument builder.
   *
   * @var \Xylemical\Router\Builder\ArgumentBuilder
   */
  protected ArgumentBuilder $argumentBuilder;

  /**
   * The parameter builder.
   *
   * @var \Xylemical\Router\Builder\ParameterBuilder
   */
  protected ParameterBuilder $parameterBuilder;

  /**
   * The controller builder.
   *
   * @var \Xylemical\Router\Builder\ControllerBuilder
   */
  protected ControllerBuilder $controllerBuilder;

  /**
   * The built definition.
   *
   * @var \Xylemical\Router\Definition\DefinitionInterface|null
   */
  protected ?DefinitionInterface $definition = NULL;

  /**
   * Builder constructor.
   *
   * @param string $class
   *   The router class name.
   * @param \Xylemical\Router\Definition\SourceInterface $source
   *   The source.
   */
  public function __construct(string $class, SourceInterface $source) {
    $this->class = $class;

    $source = new Source($source);
    $modifiers = new Modifier();
    foreach ($source->getModifiers() as $modifier) {
      $modifiers->addModifier(new $modifier());
    }
    $modifiers->apply($source);
    $this->source = $source;

    $instantiate = function ($class) {
      return new $class();
    };

    $this->routeBuilder = (new RouteBuilder())
      ->setBuilders(array_map($instantiate, $source->getRouteBuilders()));
    $this->argumentBuilder = (new ArgumentBuilder())
      ->setBuilders(array_map($instantiate, $source->getArgumentBuilders()))
      ->addBuilders([
        new EnvironmentArgumentBuilder(),
        new ServiceArgumentBuilder(),
      ]);
    $this->parameterBuilder = (new ParameterBuilder())
      ->setBuilders(array_map($instantiate, $source->getParameterBuilders()))
      ->addBuilders([
        new PathParameterBuilder(),
      ]);
    $this->controllerBuilder = (new ControllerBuilder())
      ->setBuilders(array_map($instantiate, $source->getControllerBuilders()));
  }

  /**
   * {@inheritdoc}
   */
  public function getRoute(RouteDefinition $route): ?RouteInterface {
    return $this->routeBuilder->build($route, $this);
  }

  /**
   * {@inheritdoc}
   */
  public function getArgument(RouteInterface $route, mixed $argument): ?ArgumentInterface {
    return $this->argumentBuilder->build($argument, $route, $this);
  }

  /**
   * {@inheritdoc}
   */
  public function getParameter(RouteInterface $route, string $segment, array $parameters): ?ParameterInterface {
    return $this->parameterBuilder->build($segment, $parameters, $route, $this);
  }

  /**
   * {@inheritdoc}
   */
  public function getController(RouteInterface $route, mixed $controller, array $arguments): ?ControllerInterface {
    return $this->controllerBuilder->build($controller, $arguments, $route, $this);
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinition(): DefinitionInterface {
    if (!$this->definition) {
      $this->definition = $this->build();
    }
    return $this->definition;
  }

  /**
   * Builds the definition.
   *
   * @return \Xylemical\Router\Definition\DefinitionInterface
   *   The definition.
   *
   * @throws \Xylemical\Router\Exception\InvalidDefinitionException
   */
  protected function build(): DefinitionInterface {
    $routes = [];
    foreach ($this->source->getRoutes() as $route) {
      if ($route = $this->getRoute($route)) {
        $routes[] = $route;
      }
    }
    return $this->buildDefinition($routes);
  }

  /**
   * Build the definition.
   *
   * @param \Xylemical\Router\Definition\RouteInterface[] $routes
   *   The routes.
   *
   * @return \Xylemical\Router\Definition\DefinitionInterface
   *   The definition.
   *
   * @throws \Xylemical\Router\Exception\InvalidDefinitionException
   */
  protected function buildDefinition(array $routes): DefinitionInterface {
    $class = $this->source->getClass();
    if (class_exists($class) && is_subclass_of($class, DefinitionInterface::class)) {
      return new $class($this->class, $routes);
    }
    throw new InvalidDefinitionException();
  }

}
