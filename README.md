
# Slim Route Annotations

Allow you to create routes from annotations in controllers and actions

# How to use

## Install

```
composer require marciodojr/slim-route-annotations
```

## Config

Add the key **routeAnnotations** in your settings array. Each element in the **routeAnnotations** array
is a associative array with:

- *dir*: Directory where the controllers/actions are
- *namespacePrefix*: The namespace prefix of your controllers/actions. Ex.: for a class `SomeVendor\\Controller\\MyNiceController` the *namespacePrefix* is `SomeVendor\\Controller`.


```php
<?php

// settings.php

return [
    'settings' => [
        'displayErrorDetails' => true,
        // ...
        // add this
        'routeAnnotations' => [
            [
                'dir' => __DIR__ . '/Action', // action/controller folder
                'namespacePrefix' => 'Mdojr\\SlimAnnotations\\Test\\Action' // action/controller namespace prefix
            ]
        ]
    ]
];

```

Replace the `Slim\App` by `Mdojr\SlimAnnotations\App`

```php
<?php

// index.php
// $app = new Slim\App($config)
$app = new Mdojr\SlimAnnotations\App($config)

```

Note: When using the **routerCacheFile** option, you will need to remove the cached file fist.
The annotations will not be parsed if the file exists.

## Use

Add the **@Route** annotation to the methods you want to bind a route.
The attributes **methods** and **middlewares** are optional, if the attribute **methods**
is not specified then all methods will be allowed (like  **$app->any** in Slim).

```php
<?php

namespace Mdojr\SlimAnnotations\Test\Action;

use Mdojr\SlimAnnotations\Annotation\Route;

class MyController
{
    /**
     * @Route(
     *      pattern="/test-annotated-middleware",
     *      methods={"GET"},
     *      middlewares={
     *          "Mdojr\SlimAnnotations\Test\Middleware\SomeMiddleware",
     *          "Mdojr\SlimAnnotations\Test\Middleware\SomeOtherMiddleware"
     *      }
     * )
     */
    public function myAction($request, $response)
    {
        // some code ...
    }
}

```


# Tests

```
vendor/bin/phpunit --testdox
```