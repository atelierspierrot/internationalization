Internationalization
====================

A PHP package to manage i18n: translations, pluralizations, date and number formating according to 
a localization.


## How-to

As for all our work, we try to follow the coding standards and naming rules most commonly in use:

-   the [PEAR coding standards](http://pear.php.net/manual/en/standards.php)
-   the [PHP Framework Interoperability Group standards](https://github.com/php-fig/fig-standards).

Knowing that, all classes are named and organized in an architecture to allow the use of the
[standard SplClassLoader](https://gist.github.com/jwage/221634).

The whole package is embedded in the `I18n` namespace.


## Installation

You can use this package in your work in many ways.

First, you can clone the [GitHub](https://github.com/atelierspierrot/internationalization) repository
and include it "as is" in your poject:

    https://github.com/atelierspierrot/internationalization

You can also download an [archive](https://github.com/atelierspierrot/internationalization/downloads)
from Github.

Then, to use the package classes, you just need to register the `I18n` namespace directory
using the [SplClassLoader](https://gist.github.com/jwage/221634) or any other custom autoloader:

    require_once '.../src/SplClassLoader.php'; // if required, a copy is proposed in the package
    $classLoader = new SplClassLoader('I18n', '/path/to/package/src');
    $classLoader->register();

If you are a [Composer](http://getcomposer.org/) user, just add the package to your requirements
in your `composer.json`:

    "require": {
        ...
        "atelierspierrot/internationalization": "dev-master"
    }

The namespace will be automatically added to the project Composer autoloader.


## Usage

### Object creation and PHP usage

To create a new I18n instance, you need to pass it a `I18n\Loader` object:

    // Creation of the I18n Loader
    $i18n_loader = new \I18n\Loader(array(

        // this is the directory where your language strings are defined
        'language_directory' => __DIR__.'/i18n',

        // this is the list of available languages
        'available_languages' => array(
            'en' => 'en_US_USD',
            'gb' => 'en_GB_UKP',
            'fr' => 'fr_FR_EUR'
        ),
        'default_language' => 'en',

        // this is the tag construction used for replacements in strings
        // by default, "%arg%" will be replacement by the argument "arg" value
        // as this will be passed thru a 'sprintf' PHP function, literal percent is written '%%'
        'arg_wrapper_mask' => "%%%s%%",
    ));

    // Creation of the I18n instance (statically) passing it the Loader
    $translator = \I18n\I18n::getInstance($i18n_loader);

For a full list of possible Loader options, please have a look in source code.

Any option value defining a directory path or a filename construction can contains a `%s`
tag that will be replaced by the current language.

    For instance:
        'language_directory' => __DIR__.'/i18n/%s'
    will render, for the EN language:
        'language_directory' => __DIR__.'/i18n/EN'

As you can see, the I18n class is defined as a Singleton object: any future call of 
`\I18n\I18n::getInstance()` will refer to the first created object instance.

Then, to actually use the translated value of a string, use the `translate` method:

    $translator->translate( 'string_index' [, array( arguments )] [, language code] )

You can use the `pluralize` method to choose a translated string depending on a number of items:

    $indexes = array(
        0=>'test_item_zero',
        1=>'test_item_one',
        2=>'test_item_two',
        3=>'test_item_multi'
    );
    $translator->pluralize( $indexes, $number_of_items [, array( arguments )] [, language code] )

### Translation strings definition

By default (this can be over-write in the Loader), the I18n object will load the strings
defined as a PHP array like:

    $i18n_en = array (
      'datetime_mask' => '%a %e %m %Y %H:%M:%S',
      'test' => 'Test in english',
      'test_args' => 'I received arguments : « %arg1% » and « %arg2% »',
      'test_item_zero' => 'No item',
      'test_item_one' => 'Just one item',
      'test_item_two' => 'Two items',
      'test_item_multi' => 'There are %nb% items',
    );

This may be defined in a file called `i18n.CODE.php` where `CODE` is the two letter reference
of the language. These files will be searched and loaded from the `language_directory` loader
option value.

### Package aliases

A set of aliases functions, defined in the global namespace, are available and auto-loaded
by Composer:

    function _T(...) = $i18n->translate(...)
        or
    function translate(...) = $i18n->translate(...)

    function _P(...) = $i18n->pluralize(...)
        or
    function pluralize(...) = $i18n->pluralize(...)

    function _D(...) = $i18n->getLocalizedDateString(...)
        or
    function datify(...) = $i18n->getLocalizedDateString(...)


## Extensions

The package embeds an extension to use the class in [the Twig template engine](http://twig.sensiolabs.org/).
See the [Twig Extension page](TwigExtension.md) for more infos.


## Development

To install all PHP packages for development, just run:

    ~$ composer install --dev

A documentation can be generated with [Sami](https://github.com/fabpot/Sami) running:

    ~$ php vendor/sami/sami/sami.php render sami.config.php

The latest version of this documentation is available online at <http://docs.ateliers-pierrot.fr/internationalization/>.


## Author & License

>    Internationalization

>    http://github.com/atelierspierrot/internationalization

>    Copyleft (ↄ) 2010-2015, Pierre Cassat and contributors

>    Licensed under the GPL Version 3 license.

>    http://opensource.org/licenses/GPL-3.0

>    ----

>    Les Ateliers Pierrot - Paris, France

>    <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
