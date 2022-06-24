# Router framework

Provides a framework for routing PSR-7 server requests into invokable controllers.

## Install

The recommended way to install this library is [through composer](http://getcomposer.org).

```sh
composer require xylemical/router
```

## Usage

```php

use Xylemical\Container\RouterBuilder;

$source = ...; // A source defined by \Xylemical\Router\Source\SourceInterface.
$builder = new RouterBuilder($source, 'config/router.php');
$router = $builder->getRouter();

$route = $router->match($request);
if ($route && $route->getController()) {
  $response = $route->getController()();
}
```

## License

MIT, see LICENSE.
