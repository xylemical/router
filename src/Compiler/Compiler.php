<?php

declare(strict_types=1);

namespace Xylemical\Router\Compiler;

use Twig\Environment;
use Xylemical\Code\Definition\Constant;
use Xylemical\Code\Definition\File;
use Xylemical\Code\Definition\Method;
use Xylemical\Code\Definition\Parameter;
use Xylemical\Code\Definition\Structure;
use Xylemical\Code\Expression;
use Xylemical\Code\Php\Php;
use Xylemical\Code\Php\Writer\Twig\PhpTwigExtension;
use Xylemical\Code\Php\Writer\Twig\PhpTwigLoader;
use Xylemical\Code\Visibility;
use Xylemical\Code\Writer\Twig\TwigWriter;
use Xylemical\Router\Definition\DefinitionInterface;
use Xylemical\Router\Definition\Path;
use Xylemical\Router\RouteInterface;
use Xylemical\Router\Router;
use function array_values;
use function reset;

/**
 * Provides compilation of a definition into a source file.
 */
class Compiler {

  /**
   * Perform the compilation of the definition.
   *
   * @param \Xylemical\Router\Definition\DefinitionInterface $definition
   *   The router definition.
   *
   * @return string
   *   The compiled code.
   */
  public function compile(DefinitionInterface $definition): string {
    $routes = $this->sortRoutes($definition);

    $paths = $this->doBuildPaths($routes);
    $methods = $this->doBuildMethods($routes);
    $file = $this->doBuildRoutes($definition, $paths, $methods);

    $loader = new PhpTwigLoader();
    $twig = new Environment($loader);
    $twig->addExtension(new PhpTwigExtension());
    $engine = new TwigWriter($twig);

    return $engine->write($file);

  }

  /**
   * Sort the available routes grouped by path.
   *
   * @param \Xylemical\Router\Definition\DefinitionInterface $definition
   *   The definition.
   *
   * @return \Xylemical\Router\Definition\RouteInterface[][]
   *   The sorted routes.
   */
  protected function sortRoutes(DefinitionInterface $definition): array {
    $routes = [];
    foreach ($definition->getRoutes() as $route) {
      $routes[$route->getPath()->getPath()] = $route->getPath();
    }
    uasort($routes, [Path::class, 'compare']);
    $sorted = [];
    foreach ($definition->getRoutes() as $route) {
      $path = $route->getPath()->getPath();
      foreach ($route->getMethods() ?: ['*'] as $method) {
        $sorted[$path][$method] = $route;
      }
    }
    return $sorted;
  }

  /**
   * Build the path constant for the router.
   *
   * @param \Xylemical\Router\Definition\RouteInterface[][] $routes
   *   The routes.
   *
   * @return array
   *   The router path constant.
   */
  protected function doBuildPaths(array $routes): array {
    $build = [];
    foreach ($routes as $methods) {
      $route = current($methods);

      $route_name = $route->getName();
      $segments = $route->getPath()->getSegments();
      if ($segment = reset($segments)) {
        $segment = $segment->getParameter() ? '*' : $segment;
      }

      $build[(string) $segment][] = $this->doBuildRegex($route_name, $segments);
    }

    $path = [];
    foreach ($build as $segment => $regexes) {
      foreach (array_chunk($regexes, 10) as $chunk) {
        $path[$segment][] = '`^(?:' . implode('|', $chunk) . ')$`A';
      }
    }
    return $path;
  }

  /**
   * Build the regex for the route.
   *
   * @param string $route_name
   *   The route name.
   * @param \Xylemical\Router\Definition\Segment[] $segments
   *   The path segments.
   *
   * @return string
   *   The regex.
   */
  protected function doBuildRegex(string $route_name, array $segments): string {
    $regexes = [];
    foreach ($segments as $segment) {
      if ($parameter = $segment->getParameter()) {
        $regex = str_replace('`', '\\`', $parameter->getRegex());
        $regexes[] = "({$regex})";
      }
      else {
        $regexes[] = $segment->getValue();
      }
    }
    return "(*MARK:{$route_name})" . implode('/', $regexes);
  }

  /**
   * Build the methods constant for the router.
   *
   * @param \Xylemical\Router\Definition\RouteInterface[][] $routes
   *   The routes.
   *
   * @return array
   *   The methods constant.
   */
  protected function doBuildMethods(array $routes): array {
    $build = [];
    foreach ($routes as $methods) {
      $route = current($methods);
      $route_name = $route->getName();

      foreach ($methods as $method => $route) {
        $build[$route_name][$method] = $route->getName();
      }
    }

    return array_filter($build, function ($methods) {
      return count($methods) > 1 || !isset($methods['*']);
    });
  }

  /**
   * Build the router definition.
   *
   * @param \Xylemical\Router\Definition\DefinitionInterface $definition
   *   The definition.
   * @param array $paths
   *   The path regex constant.
   * @param array $methods
   *   The methods constant.
   *
   * @return \Xylemical\Code\Definition\File
   *   The structure.
   */
  protected function doBuildRoutes(DefinitionInterface $definition, array $paths, array $methods): File {
    $file = new File('router.php');
    $manager = $file->getNameManager();

    $const = [];
    $routes = [];
    foreach (array_values($definition->getRoutes()) as $index => $route) {
      $name = 'getR' . $index;
      $const[$route->getName()] = $name;

      /** @var \Xylemical\Code\Definition\Method $method */
      $method = Method::create($name, $manager);
      $routes[$name] = $method
        ->addParameters([
          Parameter::create('route_name', $manager)->setType('string'),
          Parameter::create('parameters', $manager)->setType('array'),
        ])
        ->setType(RouteInterface::class)
        ->setValue(new Expression($route->compile()));
    }

    return $file->addStructure(
      Structure::create($definition->getClass(), $manager)
        ->setParent(Router::class)
        ->addElement(
          Constant::create('PATHS', $manager)
            ->setVisibility(Visibility::PROTECTED)
            ->setValue(new Expression(Php::export($paths)))
        )
        ->addElement(
          Constant::create('METHODS', $manager)
            ->setVisibility(Visibility::PROTECTED)
            ->setValue(new Expression(Php::export($methods)))
        )
        ->addElement(
          Constant::create('ROUTES', $manager)
            ->setVisibility(Visibility::PROTECTED)
            ->setValue(new Expression(Php::export($const)))
        )
        ->addElements($routes)
    );
  }

}
