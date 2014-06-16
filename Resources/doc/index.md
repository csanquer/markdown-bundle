CSanquer MarkdownBundle
========================

Installation
------------

### download by composer

Install by [Composer](https://getcomposer.org/)

```sh
php composer.phar require csanquer/markdown-bundle=~0.1
```

### Register the bundle in the Kernel (`app/AppKernel.php`)

```php
    [...]
    $bundles = array( 
        [...]
        new CSanquer\Bundle\ParsedownBundle\CSanquerMarkdownBundle(),
    );
```

Running Tests
-------------

* go to bundle root directory 
* install dependencies with composer 

```sh
    php composer.phar install --dev
```

* run phpunit

```sh
    phpunit
```

Usage
-----

