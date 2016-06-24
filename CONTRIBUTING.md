# KPhoenContactBundle contribution guideline

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
