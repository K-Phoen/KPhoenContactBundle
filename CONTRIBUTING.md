# KPhoenContactBundle contribution guideline

## Submitting a new issue

Coming soon.

## Getting the source code

### Getting git

You need git to get the source code.

#### Debian and derivatives (e.g. Ubuntu, Mint)

    # apt-get update
    # apt-get install git

### Cloning the repository

    $ git clone https://github.com/K-Phoen/KPhoenContactBundle.git

## Getting the dependencies

### Getting composer

You need composer to install the dependencies.

#### Debian and derivatives (e.g. Ubuntu, Mint)

    # apt-get update
    # apt-get install composer

### Installing the dependencies

    $ cd KPhoenContactBundle/
    $ composer update

## Coding conventions

### PHP

Coming soon.

### YAML

We are using [yamllint](https://github.com/adrienverge/yamllint) with the default configuration:

    $ yamllint ./Controller/ ./DependencyInjection/ ./EventDispatcher/ ./Form/ ./Model/ ./Resources/ ./Strategy/ ./Tests/ .travis.yml

### Twig and HTML

Coming soon.

## Testing

    $ cd KPhoenContactBundle/
    $ ./vendor/bin/phpunit

## Submitting a pull request

Create a fork of the repository. Make your changes, make sure you use our coding conventions then run tests. Push your changes to your fork. Create a pull request from your fork to the original repository describing your changes. Later, if you want to submit another pull request, make sure you [synced your fork](https://help.github.com/articles/syncing-a-fork/).
