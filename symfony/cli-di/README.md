Inspired by series of blog posts:

[When Symfony Http Kernel is a Too Big Hammer to Use](https://tomasvotruba.com/blog/when-symfony-http-kernel-is-too-big-hammer-to-use/)

[Decomposing Symfony Kernel: What does Minimal Symfony Bundle Do](https://tomasvotruba.com/blog/decomposing-symfony-kernel-what-does-minimal-symfony-bundle-do/)

[Introducing Light Kernel for Symfony Console Apps](https://tomasvotruba.com/blog/introducing-light-kernel-for-symfony-console-apps/)

From these articles Symplify create package `symplify-kernel`,
which allows build CLI application without `symfony/http-kernel` package.

[Symplify Kernel repository](https://github.com/symplify/symplify-kernel)

Useful articles in Symfony documentation:

[Compiling the Container](https://symfony.com/doc/current/components/dependency_injection/compilation.html)

## Usage

Call `make init` to install dependencies.

Call `docker-compose exec php php ./app.php` to see available commands.

You can edit file `config/app.php` to change `app_name` and `app_version`.
Call again `docker-compose exec php php ./app.php` to see your changes.

## Important classes

`\Symfony\Component\DependencyInjection\ContainerBuilder` - is a DI container that provides an API to easily describe services.

`\App\DependencyInjection\AppExtension` - main application extension, which load configuration
and configure `\Symfony\Component\Console\Application`.
