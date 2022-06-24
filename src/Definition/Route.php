<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

use Xylemical\Code\Php\Php;
use Xylemical\Code\Util\Indenter;
use Xylemical\Router\Route as DefaultRoute;

/**
 * Provides a generic route.
 */
class Route implements RouteInterface {

  /**
   * The name.
   *
   * @var string
   */
  protected string $name;

  /**
   * The route class.
   *
   * @var string
   */
  protected string $class = DefaultRoute::class;

  /**
   * The path.
   *
   * @var \Xylemical\Router\Definition\Path
   */
  protected Path $path;

  /**
   * The methods.
   *
   * @var string[]
   */
  protected array $methods = [];

  /**
   * The controller.
   *
   * @var \Xylemical\Router\Definition\ControllerInterface|null
   */
  protected ?ControllerInterface $controller = NULL;

  /**
   * {@inheritdoc}
   */
  public function __construct(string $name, string $path) {
    $this->name = $name;
    $this->path = new Path($path);
  }

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * {@inheritdoc}
   */
  public function getClass(): string {
    return $this->class;
  }

  /**
   * {@inheritdoc}
   */
  public function setClass(string $class): static {
    $this->class = $class;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPath(): Path {
    return $this->path;
  }

  /**
   * {@inheritdoc}
   */
  public function getMethods(): array {
    return $this->methods;
  }

  /**
   * {@inheritdoc}
   */
  public function hasMethod(string $method): bool {
    return in_array($method, $this->methods);
  }

  /**
   * {@inheritdoc}
   */
  public function addMethod(string $method): static {
    if (!in_array($method, $this->methods)) {
      $this->methods[] = $method;
    }
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function removeMethod(string $method): static {
    $this->methods = array_filter($this->methods, function ($item) use ($method) {
      return $item !== $method;
    });
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getParameters(): array {
    $parameters = [];
    foreach ($this->path->getSegments() as $segment) {
      if ($parameter = $segment->getParameter()) {
        $parameters[] = $parameter;
      }
    }
    return $parameters;
  }

  /**
   * {@inheritdoc}
   */
  public function setParameter(int $segment, ParameterInterface $parameter): static {
    $segments = $this->path->getSegments();
    if (isset($segments[$segment])) {
      $segments[$segment]->setParameter($parameter);
    }
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getController(): ?ControllerInterface {
    return $this->controller;
  }

  /**
   * {@inheritdoc}
   */
  public function setController(?ControllerInterface $controller): static {
    $this->controller = $controller;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function compile(): string {
    $variables = [
      'route' => '$route',
      'route_name' => '$route_name',
      'container' => '$this',
      'request' => '$this->request',
    ];

    $source = $this->compileRoute($variables);
    $source .= $this->compileRequest($variables);
    $source .= $this->compileController($variables);
    $source .= "return {$variables['route']};\n";
    return $source;
  }

  /**
   * Compiles the parameters for the route.
   *
   * @param array $variables
   *   The variable names.
   *
   * @return string
   *   The compiled code.
   */
  protected function compileParameters(array &$variables): string {
    $variables['parameters'] = $variables['parameters'] ?? '$parameters';
    $parameters = $this->getParameters();
    if (!count($parameters)) {
      return '';
    }

    $source = "{$variables['parameters']} = [\n";
    foreach ($parameters as $index => $parameter) {
      $name = Php::export($parameter->getName());
      $variables['parameter'] = $index;
      $source .= "  {$name} => " . $parameter->compile($variables) . ",\n";
    }
    $source .= "];\n";
    return $source;
  }

  /**
   * Compile the route.
   *
   * @param array $variables
   *   The variable names.
   *
   * @return string
   *   The compiled code.
   */
  protected function compileRoute(array &$variables): string {
    $class = trim($this->class, '\\');
    $source = $this->compileParameters($variables);
    $source .= "{$variables['route']} = new \\{$class}({$variables['route_name']}, {$variables['parameters']});\n";
    return $source;
  }

  /**
   * Compile the route request.
   *
   * @param array $variables
   *   The variable names.
   *
   * @return string
   *   The compiled code.
   */
  protected function compileRequest(array &$variables): string {
    return "{$variables['route']}->setRequest({$variables['request']});\n";
  }

  /**
   * Compile the controller.
   *
   * @param array $variables
   *   The variable names.
   *
   * @return string
   *   The controller.
   */
  protected function compileController(array &$variables): string {
    $controller = $this->controller ?
      Indenter::indent("\n" . $this->controller->compile($variables)) :
      'NULL';
    return "{$variables['route']}->setController({$controller});\n";
  }

}
