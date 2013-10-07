---
layout: layout
theme_dir: jekyll-theme

author: Kévin Gomez
title: KPhoenContactBundle
description: Yet another contact bundle
project_url: https://github.com/K-Phoen/KPhoenContactBundle
---

KPhoenContactBundle
===================

[![Build Status](https://travis-ci.org/K-Phoen/KPhoenContactBundle.png?branch=master)](https://travis-ci.org/K-Phoen/KPhoenContactBundle)

Yet another contact bundle.

Instalation
===========

## Composer

Add `kphoen/contact-bundle` to your required field. Then install/update your
dependencies.

## app/AppKernel.php

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

Configuration
=============

## config.yml

The following options are available in the `app/config/config.yml` file:

```yaml
k_phoen_contact:
    to:           foo@bar.baz
    redirect_url: homepage      # the url to retirect the user to once the mail
                                # is sent
```

## Routing

Import the routes:

```yaml
kphoen_contact:
    resource: "@KPhoenContactBundle/Resources/config/routing.yml"
```

Licence
=======

MIT. See the LICENCE file.
