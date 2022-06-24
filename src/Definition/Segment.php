<?php

declare(strict_types=1);

namespace Xylemical\Router\Definition;

/**
 * Provides a path segment.
 */
class Segment implements \Stringable {

  /**
   * The segment value.
   *
   * @var string
   */
  protected string $value;

  /**
   * The parameter details.
   *
   * @var \Xylemical\Router\Definition\ParameterInterface|null
   */
  protected ?ParameterInterface $parameter = NULL;

  /**
   * Segment constructor.
   *
   * @param string $value
   *   The value.
   */
  public function __construct(string $value) {
    $this->value = $value;
  }

  /**
   * {@inheritdoc}
   */
  public function getValue(): string {
    return $this->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getParameter(): ?ParameterInterface {
    return $this->parameter;
  }

  /**
   * {@inheritdoc}
   */
  public function setParameter(ParameterInterface $parameter): static {
    $this->parameter = $parameter;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function __toString(): string {
    return $this->value;
  }

}
