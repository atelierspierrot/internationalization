Internationalization
====================

[![demonstration](http://img.ateliers-pierrot-static.fr/see-the-demo.svg)](http://sites.ateliers-pierrot.fr/internationalization/)
[![documentation](http://img.ateliers-pierrot-static.fr/read-the-doc.svg)](http://docs.ateliers-pierrot.fr/internationalization/)
[![Code Climate](http://codeclimate.com/github/atelierspierrot/internationalization/badges/gpa.svg)](http://codeclimate.com/github/atelierspierrot/internationalization)

A PHP package to manage i18n: translations, pluralization, date and number formatting according to 
a localization.


Usage
-----

### Object creation and PHP usage

To create a new I18n instance, you need to pass it a `I18n\Loader` object:

```php
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
    // as this will be passed to a 'sprintf' PHP function, literal percent is written '%%'
    'arg_wrapper_mask' => "%%%s%%",
));

// Creation of the I18n instance (statically) passing it the Loader
$translator = \I18n\I18n::getInstance($i18n_loader);
```

For a full list of possible Loader options, please have a look in source code.

Any option value defining a directory path or a filename construction can contains a `%s`
tag that will be replaced by the current language.

```php
// for instance:
'language_directory' => __DIR__.'/i18n/%s'

// will render, for the EN language:
'language_directory' => __DIR__.'/i18n/EN'
```

As you can see, the I18n class is defined as a Singleton object: any future call of 
`\I18n\I18n::getInstance()` will refer to the first created object instance.

Then, to actually use the translated value of a string, use the `translate` method:

```php
$translator->translate( 'string_index' [, array( arguments )] [, language code] )
```

You can use the `pluralize` method to choose a translated string depending on a number of items:

```php
$indexes = array(
    0=>'test_item_zero',
    1=>'test_item_one',
    2=>'test_item_two',
    3=>'test_item_multi'
);
$translator->pluralize( $indexes, $number_of_items [, array( arguments )] [, language code] )
```

### Translation strings definition

By default (this can be over-write in the Loader), the I18n object will load the strings
defined as a PHP array like:

```php
$i18n_en = array (
  'datetime_mask' => '%a %e %m %Y %H:%M:%S',
  'test' => 'Test in english',
  'test_args' => 'I received arguments : « %arg1% » and « %arg2% »',
  'test_item_zero' => 'No item',
  'test_item_one' => 'Just one item',
  'test_item_two' => 'Two items',
  'test_item_multi' => 'There are %nb% items',
);
```

This may be defined in a file called `i18n.CODE.php` where `CODE` is the two letter reference
of the language. These files will be searched and loaded from the `language_directory` loader
option value.

### Load multiple language files

The I18n object is designed to be able to load multiple language files easily with:

```php
$i18n->loadFile( my file path )
```

Each file loaded is stored in the internal cache system of the object (a simple PHP array).

### Package aliases

A set of aliases functions, defined in the global namespace, are available and auto-loaded
by Composer:

```php
function _T(...) = $i18n->translate(...)
#    or
function translate(...) = $i18n->translate(...)

function _P(...) = $i18n->pluralize(...)
#    or
function pluralize(...) = $i18n->pluralize(...)

function _D(...) = $i18n->getLocalizedDateString(...)
#    or
function datify(...) = $i18n->getLocalizedDateString(...)
```


Extensions
----------

The package embeds an extension to use the class in [the Twig template engine](http://twig.sensiolabs.org/).
See the [Twig Extension page](TwigExtension.md) for more infos.


Installation
------------

For a complete information about how to install this package and load its namespace, 
please have a look at [our *USAGE* documentation](http://github.com/atelierspierrot/atelierspierrot/blob/master/USAGE.md).

If you are a [Composer](http://getcomposer.org/) user, just add the package to the 
requirements of your project's `composer.json` manifest file:

```json
"atelierspierrot/internationalization": "@stable"
```

You can use a specific release or the latest release of a major version using the appropriate
[version constraint](http://getcomposer.org/doc/01-basic-usage.md#package-versions).

Please note that this package depends on the externals [PHP Patterns](http://github.com/atelierspierrot/patterns)
and [PHP Library](http://github.com/atelierspierrot/library).


Author & License
----------------

>    Internationalization

>    http://github.com/atelierspierrot/internationalization

>    Copyright (c) 2010-2016, Pierre Cassat and contributors

>    Licensed under the Apache 2.0 license.

>    http://www.apache.org/licenses/LICENSE-2.0

>    ----

>    Les Ateliers Pierrot - Paris, France

>    <http://www.ateliers-pierrot.fr/> - <contact@ateliers-pierrot.fr>
