# Simple PHP REST framework

No-frills REST api framework written in PHP. Consists of Model-Controller which can easily be extended for MVC if desired. Take a look at the sample todo list implemented as an in-memory API to help you implement your own REST API.

## Basic Usage

Call REST via 

```
http://localhost/phprest.api/index.php/foo/bar
```

or if you're using the provided .htaccess

```
http://localhost/phprest.api/foo/bar
```

where

```
foo = controller, bar = action
```

Create FooController class in controllers/foo.php with function barAction()

Optional parameters can be passed in the URL itself

```
http://localhost/phprest.api/foo/bar/param1/param2/param3
```

Where you can access ```[param1, param2, param3]``` as an incoming array in ```function barAction($uri_parts)```

## REST like Usage

In this usage we can omit action and instead rely in REST verbs GET, POST, PUT and DELETE for CRUD like actions.

```
$ curl -X bar http://localhost/phprest.api/foo
```

where

```
foo = controller, bar = GET, POST, PUT or DELETE
```

Create FooController class in controllers/foo.php with function barAction(), where bar is in lowercase (e.g: get not GET)

## What's included

* docs - Documentation about testing the sample todo REST API 
* models - Where you would put any data Models. This needs to be loaded via Controller
* controllers - main.php is the default controller. See other controllers as examples.
* system - Base classes. You wouldn't need to touch these unless your extending the system

## License

[Read License](http://www.wtfpl.net/txt/copying)
