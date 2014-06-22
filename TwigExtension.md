Internationalization : the TWIG extension
=========================================

The "internationalization" package comes with a [Twig template engine](http://twig.sensiolabs.org/)
extension which allows you to use the class to translate and pluralize your texts.

Please note that this extension **IS NOT the [internal Twig "I18n" extension](http://twig.sensiolabs.org/doc/extensions/i18n.html)**.
As the internal one is made by the Twig creators, it is preferable to use it in priority.


## Usage

### Reference the extension in the Twig environement

To inform Twig that you want to use the extension, just write:

    // Creation of the I18n Loader
    $i18n_loader = new \I18n\Loader();

    // Creation of the I18n instance (statically) passing it the Loader
    $translator = \I18n\I18n::getInstance($i18n_loader);

    // Creation of the Twig loader and environment
    $loader = new Twig_Loader_String();
    $twig = new Twig_Environment($loader);

    // addition of the extension to the environment
    $twig->addExtension(new \I18n\Twig\I18nExtension($translator)); 

As you can see, you need to pass a translator instance to the extension constructor ; this
is just to force you to first define your internationalization environment.

### Extension filters

Once the extension is available in Twig, you can use the new `translate` and `datify` filters:

    {{ 'test'|translate }}

    {% set args={'arg1':'AZERTY', 'arg2':4.657} %}
    {{ 'test_args'|translate(args) }}

    {{ 'test'|translate({}, 'fr') }}

    {{ date|datify }}

### Extension functions

You can also use the `translate`, `pluralize` and `datify` functions:

    {{ translate('test') }}

    {{ translate('test_args', {'arg1':'AZERTY', 'arg2':4.657}) }}

    {{ translate('test', {}, 'fr') }}

    {{ pluralize(['test_item_zero','test_item_one','test_item_two','test_item_multi'], 0) }}

    {{ datify(date) }}

### Extension tags

Finally, for a better manipulation, the `translate` and `pluralize` features are also
defined as tags that can receive a set of parameters in any order.

The `translate` tag can be used as a block, with the string you want to translate as body,
or as a linear tag:

    {% translate %}
        string to translate
    {% endtranslate %}
    --
    {% translate "string to translate" %}
    --
    {% translate {arguments} %}
        string to translate
    {% endtranslate %}
    --
    {% translate {arguments} "string to translate" %}
    --
    {% translate 'ln' %}
    string to translate
    {% endtranslate %}
    --
    {% translate 'ln' "string to translate" %}
    --
    {% translate 'ln' {arguments} %}
    string to translate
    {% endtranslate %}
    --
    {% translate 'ln' {arguments} "string to translate" %} 

As it is more complex, the `pluralize` tag can only be used as a block, with the set of 
strings to choose as body, separated by a pipe:

    {% pluralize number %}
        test_item_zero|test_item_one | test_item_two| test_item_multi
    {% endpluralize %}
    --
    {% pluralize number {arguments} %}
    test_item_zero|test_item_one | test_item_two| test_item_multi
    {% endpluralize %}
    --
    {% pluralize number 'ln' %}
    test_item_zero|test_item_one | test_item_two| test_item_multi
    {% endpluralize %}
    --
    {% pluralize number 'ln' {arguments} %}
    test_item_zero|test_item_one | test_item_two| test_item_multi
    {% endpluralize %} 

For both tags used as block with a body, the leading and trailing spaces of the body will
be deleted so you can write your strings with spaces ...

### Extension global

The extension defines the `I18n` instance globally in the `i18n` Twig variable:

    {{ i18n.locale }}

    {% for _ln in i18n.availableLanguages %} {{ _ln }} {% endfor %}

