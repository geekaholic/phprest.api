# Simple PHP REST framework

No-frills REST api framework written in PHP. Consists of Model-Controller which can easily be extended for MVC if desired. Take a look at the sample todo list implemented as an in-memory API to help you implement your own REST API.

## Usage

Call REST via http://localhost/phprest.api/index.php/foo/bar
foo = controller, bar = action

Create FooController class in controllers/foo.php with function barAction()

## What's included

* docs - Documentation about testing the sample todo REST API 
* models - Where you would put any data Models. This needs to be loaded via Controller
* controllers - main.php is the default controller. See other controllers as examples.
* system - Base classes. You wouldn't need to touch these unless your extending the system

## License

[Read License](http://www.wtfpl.net/txt/copying)