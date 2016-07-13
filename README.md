# KPhoenContactBundle

[![Build Status](https://travis-ci.org/K-Phoen/KPhoenContactBundle.svg?branch=master)](https://travis-ci.org/K-Phoen/KPhoenContactBundle)
[![StyleCI](https://styleci.io/repos/7018780/shield)](https://styleci.io/repos/7018780)
[![Coverage Status](https://coveralls.io/repos/github/K-Phoen/KPhoenContactBundle/badge.svg?branch=master)](https://coveralls.io/github/K-Phoen/KPhoenContactBundle?branch=master)
[![Latest stable release](https://img.shields.io/github/release/K-Phoen/KPhoenContactBundle.svg?maxAge=2592000)](https://github.com/K-Phoen/KPhoenContactBundle/releases)
[![Overall downloads on Packagist](https://img.shields.io/packagist/dt/kphoen/contact-bundle.svg?maxAge=2592000)](https://packagist.org/packages/kphoen/contact-bundle)
[![license](https://img.shields.io/github/license/K-Phoen/KPhoenContactBundle.svg?maxAge=2592000)](https://github.com/K-Phoen/KPhoenContactBundle/blob/master/LICENCE)

Yet another contact bundle.

## Installation

### Composer

Add `kphoen/contact-bundle` to your required field. Then install/update your
dependencies.

### app/AppKernel.php

Register the `KPhoenContactBundle`:

```php
# app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new KPhoen\ContactBundle\KPhoenContactBundle(),
    );
}
```

## Configuration

### config.yml

The following options are available in the `app/config/config.yml` file:

```yaml
k_phoen_contact:
    redirect_url:       homepage  # the url to redirect the user to once the
                                  # mail is sent
    sender:             { address: 'no-reply@foo.org' }
    receiver:           { address: 'contact@foo.org' }
```

### Routing

Import the routes:

```yaml
kphoen_contact:
    resource: "@KPhoenContactBundle/Resources/config/routing.yml"
```

## Usage

### Routes

The previous configuration imports a route named `contact` in your application,
which correspond to a simple contact form.

### Templates

You will probably need to customize the view used by the bundle. To do that, we
will override the templates exposed by the contact bundle.

In `app/Resources/KPhoenContactBundle/views/Contact/contact.html.twig`:

```jinja
{% extends 'AcmeDemoBundle::layout.html.twig' %}

{% block title %}Contact{% endblock %}

{% block body %}
<h2>Contact</h2>

{% include "KPhoenContactBundle:Contact:form.html.twig" with {'form': form} %}
{% endblock %}
```

### Events

Two events are emitted during the submission of the event form:

 * `contact.pre_send`: emitted just before the mail is sent ;
 * `contact.post_send`: emitted just after.

## Contributing

See the [CONTRIBUTING](https://github.com/K-Phoen/KPhoenContactBundle/blob/master/CONTRIBUTING.md) file.
