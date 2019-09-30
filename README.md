# Named enum for PHP 7.1 +

[![Latest Stable Version](https://poser.pugx.org/mesavolt/inflector/v/stable)](https://packagist.org/packages/mesavolt/inflector)
[![Build Status](https://travis-ci.org/MesaVolt/inflector.svg)](https://travis-ci.org/MesaVolt/inflector)
[![Coverage Status](https://coveralls.io/repos/github/MesaVolt/inflector/badge.svg)](https://coveralls.io/github/MesaVolt/inflector)
[![License](https://poser.pugx.org/mesavolt/inflector/license)](https://packagist.org/packages/mesavolt/inflector)

## Usage

Add the package to your project :

```bash
composer require mesavolt/inflector
```

```php
// Use it with any number or countable value:
Inflector::plural('cheval', 2);     // Returns 'chevaux'
Inflector::plural('cheval', 1);     // Returns 'chevaux'
Inflector::plural('cheval', [$horse1, $horse2]); // Returns 'chevaux'

// Specify the plural form if you want:
Inflector::plural('cheval', 2, 'chevals');     // Returns 'chevals'
Inflector::plural('un petit cheval', 2, 'des petits chevaux'); // Returns 'des petits chevaux'
```

## Integration

### Symfony >=3 with Twig >1.26

If you use the default
[auto-configuring feature of Symfony introduced in Symfony 3.3](https://symfony.com/doc/current/service_container/3.3-di-changes.html),
you only need to register the `MesaVolt\Twig\InflectorExtension` as a service in your `services.yml` file.
Symfony will tag it properly to register it in the twig environment used by your app.

If you don't use the auto-configuring feature or if it's not available in your version,
you need to apply the tags manually when you register the extension as a service.

```yaml
# Symfony 3: app/config/services.yml
# Symfony 4: config/services.yaml
services:

    # Use this if you use the default auto-configuring feature of Symfony >=3.3  DI container
    MesaVolt\Twig\InflectorExtension: ~

    # Use this if you **don't** use the auto-configuring feature of Symfony >=3.3 DI container
    app.inflector_extension:
        class: MesaVolt\Twig\InflectorExtension
        tags: { name: twig.extension }
```

Then, you can use the `plural` filter provided by the extension in your templates :

```twig
{# templates/my-template.html.twig #}

<p>Il y a {{ 'utilisateur'|plural(users) }} utilisateurs dans la base de données.</p>
```


## Testing

```bash
composer dump-autoload # make sure vendor/autoload.php exists
./vendor/bin/phpunit
```
