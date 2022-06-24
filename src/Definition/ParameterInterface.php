<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

/**
 * The parameter for the route.
 */
interface ParameterInterface {

  /**
   * The parameter name.
   *
   * @return string
   *   The name.
   */
  public function getName(): string;

  /**
   * The regex used to match the parameter.
   *
   * @return string
   *   The regex.
   */
  public function getRegex(): string;

  /**
   * Compile the parameter to be provided for the route.
   *
   * @param array $variables
   *   The variable names.
   *     'route_name' - the route name variable
   *     'route' - the route variable name
   *     'container' - the variable name for the container
   *     'request' - the variable name for the request
   *     'parameters' - the parameters variable name
   *     'parameter' - the parameter index into the parameters variable.
   *
   * @return string
   *   The compiled parameter.
   */
  public function compile(array &$variables): string;

}
