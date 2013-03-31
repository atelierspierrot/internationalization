Internationalization : the TWIG extension
=========================================

The "internationalization" package comes with a [Twig template engine](http://twig.sensiolabs.org/)
extension which allows you to use the class to translate and pluralize your texts.


## Usage

### Reference the extension in the Twig environement

To inform Twig that you want to use the extension, just write:

    // Creation of the I18n Loader
    $i18n_loader = new \I18n\Loader();

    // Creation of the I18n instance (statically) passing it the Loader
    $translator = \I18n\I18n::getInstance($i18n_loader);

    // Creation of the Twig loader and environement
    $loader = new Twig_Loader_String();
    $twig = new Twig_Environment($loader);

    // addition of the extension to the environement
    $twig->addExtension(new \I18n\Twig\Extension($translator)); 

As you can see, you need to pass a translator instance to the extension constructor ; this
is just to force you to first define your internationalization environement.

### Some filters, some functions, one global and two tags

Once the extension is available in Twig, you can use the new `translate` and `datify` filters:

    {{ 'test'|translate }}

    {% set args={'arg1':'AZERTY', 'arg2':4.657} %}
    {{ 'test_args'|translate(args) }}

    {{ 'test'|translate({}, 'fr') }}

    {{ date|datify }}

You can also use the `translate`, `pluralize` and `datify` functions:

    {{ translate('test') }}

    {{ translate('test_args', {'arg1':'AZERTY', 'arg2':4.657}) }}

    {{ translate('test', {}, 'fr') }}

    {{ pluralize(['test_item_zero','test_item_one','test_item_two','test_item_multi'], 0) }}

    {{ datify(date) }}

Finally, for a better manipulation, the `translate` and `pluralize` functionalities are also
defined as tags:

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
    --
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

The extension defines the `I18n` instance globally in the `i18n` Twig global:

    {{ i18n.locale }}

    {% for _ln in i18n.availableLanguages %} {{ _ln }} {% endfor %}

