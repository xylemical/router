<?php

declare(strict_types=1);

namespace Xylemical\Router;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Provides the router interface.
 */
interface RouterInterface {

  /**
   * Match a server request to a route.
   *
   * @param \Psr\Http\Message\ServerRequestInterface $request
   *   The request.
   *
   * @return \Xylemical\Router\RouteInterface|null
   *   The route or NULL.
   */
  public function match(ServerRequestInterface $request): ?RouteInterface;

}
