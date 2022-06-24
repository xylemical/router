<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

/**
 * Provides a generic parameter.
 */
class Parameter implements ParameterInterface {

  /**
   * The name of the parameter.
   *
   * @var string
   */
  protected string $name;

  /**
   * The regular expression for the parameter.
   *
   * @var string
   */
  protected string $regex;

  /**
   * Parameter constructor.
   *
   * @param string $name
   *   The name.
   * @param string $regex
   *   The regular expression.
   */
  public function __construct(string $name, string $regex) {
    $this->name = $name;
    $this->regex = $regex;
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
  public function getRegex(): string {
    return $this->regex;
  }

  /**
   * {@inheritdoc}
   */
  public function compile(array &$variables): string {
    return "{$variables['parameters']}[{$variables['parameter']}]";
  }

}
