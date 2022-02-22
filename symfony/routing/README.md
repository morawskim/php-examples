## Usage

Call `make init` to install dependencies.

Open `127.0.0.1:8000` in your favourite webbrowser. You should see very simple Homepage.

Click on some link on Homepage.

## Important classes

In Symfony 5.x we could use `RouteCollectionBuilder` to create [RouteCollection](https://github.com/symfony/routing/blob/44b29c7a94e867ccde1da604792f11a469958981/RouteCollectionBuilder.php) 

In this simple application we use `\Symfony\Component\Routing\Loader\AnnotationFileLoader` to load routes from the controllers stored in `src/Controller`.
To match request we use default implementation of `\Symfony\Component\Routing\Matcher\RequestMatcherInterface`.
Private method `\App\Kernel::runController` is responsible to run controller's action.

The class `\Symfony\Component\Routing\Loader\AnnotationDirectoryLoader` is very good example how to load the attribute and add Route to collection.  

[The Routing Component](https://symfony.com/doc/current/create_framework/routing.html)
