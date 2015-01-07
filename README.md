# KPhoenContactBundle

[![Build Status](https://travis-ci.org/K-Phoen/KPhoenContactBundle.png?branch=master)](https://travis-ci.org/K-Phoen/KPhoenContactBundle)

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

## License

MIT. See the LICENSE file.
