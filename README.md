# COLORFULframework

- [Getting started](#gettingstarted)
- [Methods](#methods)
- [Execution](#execution)
- [Nextines](#nextines)

<br>

## <a id="gettingstarted"></a>Getting started

### Require

```
composer require sintloer/colorful
```

### Install

```
composer install
```

### Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use sintloer\COLORFUL\Creation;
$COLORFULframework = new Creation('DEVELOPMENT'); // DEVELOPMENT OR PRODUCTION
```

## <a id="methods"></a>Methods

**NOTE:** Each available method on a _**COLORFUL\Creation**_ object returns the current object, but only if the method has been used correctly.

### before()
This is run at the very beginning of the execution process.
You can configure modules here or create objects for later use with Store [Nextine](#nextines).

```php
$COLORFULframework->before(function($request, $response) {
    return 1;
});
```

You can also use:

```php
class Simple
{
	public function any($request, $response)
    {
    	return 1;
    }
}

$COLORFULframework->before([ Simple::class, 'any' ]);
```

### after()
This method is the same as before() except that it is executed at the end of the execution process.

### when()
This method creates a listener for an event generated by the COLORFULframework.<br>
**At this moment, the following events are available:**
- lack (executed if **no** matching route was found.)
- found (executed if matching route was found.)

Events are executed before a route callback can be made.

```php
$COLORFULframework->when('lack', function($request, $response) {
	return $response->error('Not found.');
});
```

You can also:

```php
$COLORFULframework->when([
	'lack' => function($request, $response) {
    	return $response->error('Not found.');
    }
]);
```

or:

```php
class Simple
{
	public function any($request, $response)
    {
    	return $response->error('Not found.');
    }
}

$COLORFULframework->when([
	'lack' => [ Simple::class, 'any' ]
]);
```

### routes()
This method creates routes. Supported methods are GET, POST, PUT, PATCH and DELETE.

```php
$COLORFULframework->routes([
	'GET' => [
    	'/test' => function($request, $response) {
        	return 1;
        }
    ]
]);
```

You can use more methods:

```php
$COLORFULframework->routes([
	'GET, POST, DELETE' => [
    	'/test' => function($request, $response) {
        	switch($request->method())
            {
            	case 'GET':
                	echo 'Operations for GET request.';
                    break;

                case 'POST':
                	echo 'Operations for POST request.';
                    break;

                case 'DELETE':
                	echo 'Operations for DELETE request.';
                    break;
            }
        }
    ]
]);
```

Instead of an anonymous function, you can use the class and method as in the methods above:

```php
class Simple
{
	public function any($request, $response, $id)
    {
    	return $response->json([ 'id' => $id ])
    }
}

$COLORFULframework->routes([
	'GET' => [
    	'/test/:id' => [ Simple::class, 'any' ]
    ]
]);
```

If you want to, you can create a prefix, for example, for the API:

```php

// Routes for /v1/

$COLORFULframework->routes([
	// routes
], 'v1');

// Routes for /v2/

$COLORFULframework->routes([
	// routes
], 'v2');
```

You can also create route by a simple method [get(), post(), put(), patch(), delete()]:

```php
$COLORFULframework->get('/simple/:id', function($request, $response, $id) {
	if($id > 10)
    	return $response->json([ 'success' => true ]);
});
```

### run()
This method starts the [execution process](#execution). It is not required to use because it is run by the destructor of the COLORFUL\Creation object.

## <a id="execution"></a>executionPROCESS
![executionProcess](https://raw.githubusercontent.com/sintloer/colorful/master/assets/images/execution.png)

## <a id="nextines"></a>nextines
Nextines are separate components that support application development. For example, Store Nextine is used to store objects for later use (next methods).<br><br>
**At this moment, the following Nextines are available:**
- Store (store objects)
- Session (session management)
- Cookie (cookie management)
