(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '    <ul>                <li data-name="namespace:I18n" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="I18n.html">I18n</a>                    </div>                    <div class="bd">                            <ul>                <li data-name="namespace:I18n_Generator" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="I18n/Generator.html">Generator</a>                    </div>                    <div class="bd">                            <ul>                <li data-name="class:I18n_Generator_Csv" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="I18n/Generator/Csv.html">Csv</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:I18n_Twig" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="I18n/Twig.html">Twig</a>                    </div>                    <div class="bd">                            <ul>                <li data-name="class:I18n_Twig_I18nExtension" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="I18n/Twig/I18nExtension.html">I18nExtension</a>                    </div>                </li>                            <li data-name="class:I18n_Twig_PluralizeNode" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="I18n/Twig/PluralizeNode.html">PluralizeNode</a>                    </div>                </li>                            <li data-name="class:I18n_Twig_PluralizeTokenParser" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="I18n/Twig/PluralizeTokenParser.html">PluralizeTokenParser</a>                    </div>                </li>                            <li data-name="class:I18n_Twig_TranslateNode" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="I18n/Twig/TranslateNode.html">TranslateNode</a>                    </div>                </li>                            <li data-name="class:I18n_Twig_TranslateTokenParser" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="I18n/Twig/TranslateTokenParser.html">TranslateTokenParser</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:I18n_Generator" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="I18n/Generator.html">Generator</a>                    </div>                </li>                            <li data-name="class:I18n_GeneratorInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="I18n/GeneratorInterface.html">GeneratorInterface</a>                    </div>                </li>                            <li data-name="class:I18n_I18n" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="I18n/I18n.html">I18n</a>                    </div>                </li>                            <li data-name="class:I18n_I18nException" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="I18n/I18nException.html">I18nException</a>                    </div>                </li>                            <li data-name="class:I18n_I18nInvalidArgumentException" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="I18n/I18nInvalidArgumentException.html">I18nInvalidArgumentException</a>                    </div>                </li>                            <li data-name="class:I18n_I18nRuntimeException" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="I18n/I18nRuntimeException.html">I18nRuntimeException</a>                    </div>                </li>                            <li data-name="class:I18n_Iana" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="I18n/Iana.html">Iana</a>                    </div>                </li>                            <li data-name="class:I18n_Loader" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="I18n/Loader.html">Loader</a>                    </div>                </li>                            <li data-name="class:I18n_LoaderInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="I18n/LoaderInterface.html">LoaderInterface</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    {"type": "Namespace", "link": "I18n.html", "name": "I18n", "doc": "Namespace I18n"},{"type": "Namespace", "link": "I18n/Generator.html", "name": "I18n\\Generator", "doc": "Namespace I18n\\Generator"},{"type": "Namespace", "link": "I18n/Twig.html", "name": "I18n\\Twig", "doc": "Namespace I18n\\Twig"},
            {"type": "Interface", "fromName": "I18n", "fromLink": "I18n.html", "link": "I18n/GeneratorInterface.html", "name": "I18n\\GeneratorInterface", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\GeneratorInterface", "fromLink": "I18n/GeneratorInterface.html", "link": "I18n/GeneratorInterface.html#method_generate", "name": "I18n\\GeneratorInterface::generate", "doc": "&quot;\n&quot;"},
            
            {"type": "Interface", "fromName": "I18n", "fromLink": "I18n.html", "link": "I18n/LoaderInterface.html", "name": "I18n\\LoaderInterface", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_getOption", "name": "I18n\\LoaderInterface::getOption", "doc": "&quot;Get the value of a specific option&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageFileName", "name": "I18n\\LoaderInterface::buildLanguageFileName", "doc": "&quot;Build the file name for the language database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageDirName", "name": "I18n\\LoaderInterface::buildLanguageDirName", "doc": "&quot;Build the directory name for the language database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageFilePath", "name": "I18n\\LoaderInterface::buildLanguageFilePath", "doc": "&quot;Build the absolute file path for the language database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageVarname", "name": "I18n\\LoaderInterface::buildLanguageVarname", "doc": "&quot;Build the variable name for the language database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageDBFileName", "name": "I18n\\LoaderInterface::buildLanguageDBFileName", "doc": "&quot;Build the file name for the language CSV database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageDBDirName", "name": "I18n\\LoaderInterface::buildLanguageDBDirName", "doc": "&quot;Build the directory name for the language CSV database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageDBFilePath", "name": "I18n\\LoaderInterface::buildLanguageDBFilePath", "doc": "&quot;Build the absolute file path for the language CSV database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_findLanguageDBFile", "name": "I18n\\LoaderInterface::findLanguageDBFile", "doc": "&quot;Find a language file from options directories&quot;"},
            
            
            {"type": "Class", "fromName": "I18n", "fromLink": "I18n.html", "link": "I18n/Generator.html", "name": "I18n\\Generator", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\Generator", "fromLink": "I18n/Generator.html", "link": "I18n/Generator.html#method___construct", "name": "I18n\\Generator::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Generator", "fromLink": "I18n/Generator.html", "link": "I18n/Generator.html#method_setDbFilepath", "name": "I18n\\Generator::setDbFilepath", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Generator", "fromLink": "I18n/Generator.html", "link": "I18n/Generator.html#method_getDbFilepath", "name": "I18n\\Generator::getDbFilepath", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Generator", "fromLink": "I18n/Generator.html", "link": "I18n/Generator.html#method_setGenerator", "name": "I18n\\Generator::setGenerator", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Generator", "fromLink": "I18n/Generator.html", "link": "I18n/Generator.html#method_getGenerator", "name": "I18n\\Generator::getGenerator", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Generator", "fromLink": "I18n/Generator.html", "link": "I18n/Generator.html#method_generate", "name": "I18n\\Generator::generate", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "I18n", "fromLink": "I18n.html", "link": "I18n/GeneratorInterface.html", "name": "I18n\\GeneratorInterface", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\GeneratorInterface", "fromLink": "I18n/GeneratorInterface.html", "link": "I18n/GeneratorInterface.html#method_generate", "name": "I18n\\GeneratorInterface::generate", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "I18n\\Generator", "fromLink": "I18n/Generator.html", "link": "I18n/Generator/Csv.html", "name": "I18n\\Generator\\Csv", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\Generator\\Csv", "fromLink": "I18n/Generator/Csv.html", "link": "I18n/Generator/Csv.html#method_generate", "name": "I18n\\Generator\\Csv::generate", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "I18n", "fromLink": "I18n.html", "link": "I18n/I18n.html", "name": "I18n\\I18n", "doc": "&quot;Internationalization class&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_setLoader", "name": "I18n\\I18n::setLoader", "doc": "&quot;Store the loader&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getLoader", "name": "I18n\\I18n::getLoader", "doc": "&quot;Gets the loader&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_loadFile", "name": "I18n\\I18n::loadFile", "doc": "&quot;Load a new language file&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_setLanguage", "name": "I18n\\I18n::setLanguage", "doc": "&quot;Loads a new language&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getLanguage", "name": "I18n\\I18n::getLanguage", "doc": "&quot;Get the current language code used&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_setDefaultFromHttp", "name": "I18n\\I18n::setDefaultFromHttp", "doc": "&quot;Try to get the browser default locale and use it&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_isAvailableLanguage", "name": "I18n\\I18n::isAvailableLanguage", "doc": "&quot;Check if a language code is available in the Loader&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getAvailableLocale", "name": "I18n\\I18n::getAvailableLocale", "doc": "&quot;Get the full locale info for a language code&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getAvailableLanguages", "name": "I18n\\I18n::getAvailableLanguages", "doc": "&quot;Get the list of &lt;code&gt;Loader::available_languages&lt;\/code&gt;&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_setLocale", "name": "I18n\\I18n::setLocale", "doc": "&quot;Define a new locale for the system&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getLocale", "name": "I18n\\I18n::getLocale", "doc": "&quot;Get the current locale used by the system&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_setTimezone", "name": "I18n\\I18n::setTimezone", "doc": "&quot;Define a new timezone for the system&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getTimezone", "name": "I18n\\I18n::getTimezone", "doc": "&quot;Get the current timezone used by the system&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_hasLocalizedString", "name": "I18n\\I18n::hasLocalizedString", "doc": "&quot;Check if a translation exists for an index&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getLocalizedString", "name": "I18n\\I18n::getLocalizedString", "doc": "&quot;Get the translation of an index&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_parseString", "name": "I18n\\I18n::parseString", "doc": "&quot;Parse a translated string making some parameters replacements&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_parseStringMetadata", "name": "I18n\\I18n::parseStringMetadata", "doc": "&quot;Get the meta-data of a language string&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getCurrency", "name": "I18n\\I18n::getCurrency", "doc": "&quot;Get the currency of the current locale&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getHttpHeaderLocale", "name": "I18n\\I18n::getHttpHeaderLocale", "doc": "&quot;Get the browser requested locale if so&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getAvailableLanguagesNames", "name": "I18n\\I18n::getAvailableLanguagesNames", "doc": "&quot;Get the full list of &lt;code&gt;Loader::available_languages&lt;\/code&gt; option like human readable names&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getLanguageCode", "name": "I18n\\I18n::getLanguageCode", "doc": "&quot;Get the language code of the current locale&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getRegionCode", "name": "I18n\\I18n::getRegionCode", "doc": "&quot;Get the region code of the current locale&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getScriptCode", "name": "I18n\\I18n::getScriptCode", "doc": "&quot;Get the script code of the current locale&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getKeywords", "name": "I18n\\I18n::getKeywords", "doc": "&quot;Get the keywords of the current locale&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getKeyword", "name": "I18n\\I18n::getKeyword", "doc": "&quot;Get one keyword value of the current locale&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getPrimaryLanguage", "name": "I18n\\I18n::getPrimaryLanguage", "doc": "&quot;Get the primary language of a locale&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getLanguageName", "name": "I18n\\I18n::getLanguageName", "doc": "&quot;Get the language name of a locale&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getCountryName", "name": "I18n\\I18n::getCountryName", "doc": "&quot;Get the country name of a locale&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getLocaleScript", "name": "I18n\\I18n::getLocaleScript", "doc": "&quot;Get the script name of a locale&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getLocaleVariant", "name": "I18n\\I18n::getLocaleVariant", "doc": "&quot;Get the variant name of a locale&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getLocalizedNumberString", "name": "I18n\\I18n::getLocalizedNumberString", "doc": "&quot;Get a localized number value&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getLocalizedPriceString", "name": "I18n\\I18n::getLocalizedPriceString", "doc": "&quot;Get a localized price value&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_getLocalizedDateString", "name": "I18n\\I18n::getLocalizedDateString", "doc": "&quot;Get a localized date value&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_translate", "name": "I18n\\I18n::translate", "doc": "&quot;Process a translation with arguments&quot;"},
                    {"type": "Method", "fromName": "I18n\\I18n", "fromLink": "I18n/I18n.html", "link": "I18n/I18n.html#method_pluralize", "name": "I18n\\I18n::pluralize", "doc": "&quot;Process a translation with arguments depending on a counter&quot;"},
            
            {"type": "Class", "fromName": "I18n", "fromLink": "I18n.html", "link": "I18n/I18nException.html", "name": "I18n\\I18nException", "doc": "&quot;\n&quot;"},
                    
            {"type": "Class", "fromName": "I18n", "fromLink": "I18n.html", "link": "I18n/I18nInvalidArgumentException.html", "name": "I18n\\I18nInvalidArgumentException", "doc": "&quot;\n&quot;"},
                    
            {"type": "Class", "fromName": "I18n", "fromLink": "I18n.html", "link": "I18n/I18nRuntimeException.html", "name": "I18n\\I18nRuntimeException", "doc": "&quot;\n&quot;"},
                    
            {"type": "Class", "fromName": "I18n", "fromLink": "I18n.html", "link": "I18n/Iana.html", "name": "I18n\\Iana", "doc": "&quot;Locale codes DB from &lt;a href=\&quot;http:\/\/www.iana.org\/assignments\/language-subtag-registry\&quot;&gt;http:\/\/www.iana.org\/assignments\/language-subtag-registry&lt;\/a&gt;&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method___construct", "name": "I18n\\Iana::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method_setDbFilepath", "name": "I18n\\Iana::setDbFilepath", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method_getDbFilepath", "name": "I18n\\Iana::getDbFilepath", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method_setDbFilename", "name": "I18n\\Iana::setDbFilename", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method_getDbFilename", "name": "I18n\\Iana::getDbFilename", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method_getDbRealpath", "name": "I18n\\Iana::getDbRealpath", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method_update", "name": "I18n\\Iana::update", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method_read", "name": "I18n\\Iana::read", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method_getDb", "name": "I18n\\Iana::getDb", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method_getLanguages", "name": "I18n\\Iana::getLanguages", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method_getRegions", "name": "I18n\\Iana::getRegions", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method_getScripts", "name": "I18n\\Iana::getScripts", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Iana", "fromLink": "I18n/Iana.html", "link": "I18n/Iana.html#method_getExtlangs", "name": "I18n\\Iana::getExtlangs", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "I18n", "fromLink": "I18n.html", "link": "I18n/Loader.html", "name": "I18n\\Loader", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\Loader", "fromLink": "I18n/Loader.html", "link": "I18n/Loader.html#method___construct", "name": "I18n\\Loader::__construct", "doc": "&quot;Creation of a Loader with an optional user defined set of options&quot;"},
                    {"type": "Method", "fromName": "I18n\\Loader", "fromLink": "I18n/Loader.html", "link": "I18n/Loader.html#method_addPath", "name": "I18n\\Loader::addPath", "doc": "&quot;Add a path to the registry&quot;"},
                    {"type": "Method", "fromName": "I18n\\Loader", "fromLink": "I18n/Loader.html", "link": "I18n/Loader.html#method_getParsedOption", "name": "I18n\\Loader::getParsedOption", "doc": "&quot;Parse an option value replacing &lt;code&gt;%s&lt;\/code&gt; by the actual language code&quot;"},
                    {"type": "Method", "fromName": "I18n\\Loader", "fromLink": "I18n/Loader.html", "link": "I18n/Loader.html#method_buildLanguageFileName", "name": "I18n\\Loader::buildLanguageFileName", "doc": "&quot;Build the file name for the language database&quot;"},
                    {"type": "Method", "fromName": "I18n\\Loader", "fromLink": "I18n/Loader.html", "link": "I18n/Loader.html#method_buildLanguageDirName", "name": "I18n\\Loader::buildLanguageDirName", "doc": "&quot;Build the directory name for the language database&quot;"},
                    {"type": "Method", "fromName": "I18n\\Loader", "fromLink": "I18n/Loader.html", "link": "I18n/Loader.html#method_buildLanguageFilePath", "name": "I18n\\Loader::buildLanguageFilePath", "doc": "&quot;Build the absolute file path for the language database&quot;"},
                    {"type": "Method", "fromName": "I18n\\Loader", "fromLink": "I18n/Loader.html", "link": "I18n/Loader.html#method_buildLanguageVarname", "name": "I18n\\Loader::buildLanguageVarname", "doc": "&quot;Build the variable name for the language database&quot;"},
                    {"type": "Method", "fromName": "I18n\\Loader", "fromLink": "I18n/Loader.html", "link": "I18n/Loader.html#method_buildLanguageDBFileName", "name": "I18n\\Loader::buildLanguageDBFileName", "doc": "&quot;Build the file name for the language CSV database&quot;"},
                    {"type": "Method", "fromName": "I18n\\Loader", "fromLink": "I18n/Loader.html", "link": "I18n/Loader.html#method_buildLanguageDBDirName", "name": "I18n\\Loader::buildLanguageDBDirName", "doc": "&quot;Build the directory name for the language CSV database&quot;"},
                    {"type": "Method", "fromName": "I18n\\Loader", "fromLink": "I18n/Loader.html", "link": "I18n/Loader.html#method_buildLanguageDBFilePath", "name": "I18n\\Loader::buildLanguageDBFilePath", "doc": "&quot;Build the file path for the language CSV database&quot;"},
                    {"type": "Method", "fromName": "I18n\\Loader", "fromLink": "I18n/Loader.html", "link": "I18n/Loader.html#method_findLanguageDBFile", "name": "I18n\\Loader::findLanguageDBFile", "doc": "&quot;Find (and add if needed) a language file from options directories&quot;"},
            
            {"type": "Class", "fromName": "I18n", "fromLink": "I18n.html", "link": "I18n/LoaderInterface.html", "name": "I18n\\LoaderInterface", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_getOption", "name": "I18n\\LoaderInterface::getOption", "doc": "&quot;Get the value of a specific option&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageFileName", "name": "I18n\\LoaderInterface::buildLanguageFileName", "doc": "&quot;Build the file name for the language database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageDirName", "name": "I18n\\LoaderInterface::buildLanguageDirName", "doc": "&quot;Build the directory name for the language database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageFilePath", "name": "I18n\\LoaderInterface::buildLanguageFilePath", "doc": "&quot;Build the absolute file path for the language database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageVarname", "name": "I18n\\LoaderInterface::buildLanguageVarname", "doc": "&quot;Build the variable name for the language database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageDBFileName", "name": "I18n\\LoaderInterface::buildLanguageDBFileName", "doc": "&quot;Build the file name for the language CSV database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageDBDirName", "name": "I18n\\LoaderInterface::buildLanguageDBDirName", "doc": "&quot;Build the directory name for the language CSV database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_buildLanguageDBFilePath", "name": "I18n\\LoaderInterface::buildLanguageDBFilePath", "doc": "&quot;Build the absolute file path for the language CSV database&quot;"},
                    {"type": "Method", "fromName": "I18n\\LoaderInterface", "fromLink": "I18n/LoaderInterface.html", "link": "I18n/LoaderInterface.html#method_findLanguageDBFile", "name": "I18n\\LoaderInterface::findLanguageDBFile", "doc": "&quot;Find a language file from options directories&quot;"},
            
            {"type": "Class", "fromName": "I18n\\Twig", "fromLink": "I18n/Twig.html", "link": "I18n/Twig/I18nExtension.html", "name": "I18n\\Twig\\I18nExtension", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\Twig\\I18nExtension", "fromLink": "I18n/Twig/I18nExtension.html", "link": "I18n/Twig/I18nExtension.html#method___construct", "name": "I18n\\Twig\\I18nExtension::__construct", "doc": "&quot;You can construct this extension by passing a &lt;code&gt;\\I18n\\I18n&lt;\/code&gt; object instance or just\na &lt;code&gt;\\I18n\\LoaderInterface&lt;\/code&gt; object or just an array of options.&quot;"},
                    {"type": "Method", "fromName": "I18n\\Twig\\I18nExtension", "fromLink": "I18n/Twig/I18nExtension.html", "link": "I18n/Twig/I18nExtension.html#method_getName", "name": "I18n\\Twig\\I18nExtension::getName", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Twig\\I18nExtension", "fromLink": "I18n/Twig/I18nExtension.html", "link": "I18n/Twig/I18nExtension.html#method_getGlobals", "name": "I18n\\Twig\\I18nExtension::getGlobals", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Twig\\I18nExtension", "fromLink": "I18n/Twig/I18nExtension.html", "link": "I18n/Twig/I18nExtension.html#method_getFilters", "name": "I18n\\Twig\\I18nExtension::getFilters", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Twig\\I18nExtension", "fromLink": "I18n/Twig/I18nExtension.html", "link": "I18n/Twig/I18nExtension.html#method_getFunctions", "name": "I18n\\Twig\\I18nExtension::getFunctions", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Twig\\I18nExtension", "fromLink": "I18n/Twig/I18nExtension.html", "link": "I18n/Twig/I18nExtension.html#method_getTokenParsers", "name": "I18n\\Twig\\I18nExtension::getTokenParsers", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "I18n\\Twig", "fromLink": "I18n/Twig.html", "link": "I18n/Twig/PluralizeNode.html", "name": "I18n\\Twig\\PluralizeNode", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\Twig\\PluralizeNode", "fromLink": "I18n/Twig/PluralizeNode.html", "link": "I18n/Twig/PluralizeNode.html#method___construct", "name": "I18n\\Twig\\PluralizeNode::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Twig\\PluralizeNode", "fromLink": "I18n/Twig/PluralizeNode.html", "link": "I18n/Twig/PluralizeNode.html#method_compile", "name": "I18n\\Twig\\PluralizeNode::compile", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "I18n\\Twig", "fromLink": "I18n/Twig.html", "link": "I18n/Twig/PluralizeTokenParser.html", "name": "I18n\\Twig\\PluralizeTokenParser", "doc": "&quot;Use the I18n\\I18n::translate function&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\Twig\\PluralizeTokenParser", "fromLink": "I18n/Twig/PluralizeTokenParser.html", "link": "I18n/Twig/PluralizeTokenParser.html#method_parse", "name": "I18n\\Twig\\PluralizeTokenParser::parse", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Twig\\PluralizeTokenParser", "fromLink": "I18n/Twig/PluralizeTokenParser.html", "link": "I18n/Twig/PluralizeTokenParser.html#method_getTag", "name": "I18n\\Twig\\PluralizeTokenParser::getTag", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Twig\\PluralizeTokenParser", "fromLink": "I18n/Twig/PluralizeTokenParser.html", "link": "I18n/Twig/PluralizeTokenParser.html#method_isEndTag", "name": "I18n\\Twig\\PluralizeTokenParser::isEndTag", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "I18n\\Twig", "fromLink": "I18n/Twig.html", "link": "I18n/Twig/TranslateNode.html", "name": "I18n\\Twig\\TranslateNode", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\Twig\\TranslateNode", "fromLink": "I18n/Twig/TranslateNode.html", "link": "I18n/Twig/TranslateNode.html#method___construct", "name": "I18n\\Twig\\TranslateNode::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Twig\\TranslateNode", "fromLink": "I18n/Twig/TranslateNode.html", "link": "I18n/Twig/TranslateNode.html#method_compile", "name": "I18n\\Twig\\TranslateNode::compile", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "I18n\\Twig", "fromLink": "I18n/Twig.html", "link": "I18n/Twig/TranslateTokenParser.html", "name": "I18n\\Twig\\TranslateTokenParser", "doc": "&quot;Use the I18n\\I18n::translate function&quot;"},
                                                        {"type": "Method", "fromName": "I18n\\Twig\\TranslateTokenParser", "fromLink": "I18n/Twig/TranslateTokenParser.html", "link": "I18n/Twig/TranslateTokenParser.html#method_parse", "name": "I18n\\Twig\\TranslateTokenParser::parse", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Twig\\TranslateTokenParser", "fromLink": "I18n/Twig/TranslateTokenParser.html", "link": "I18n/Twig/TranslateTokenParser.html#method_getTag", "name": "I18n\\Twig\\TranslateTokenParser::getTag", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "I18n\\Twig\\TranslateTokenParser", "fromLink": "I18n/Twig/TranslateTokenParser.html", "link": "I18n/Twig/TranslateTokenParser.html#method_isEndTag", "name": "I18n\\Twig\\TranslateTokenParser::isEndTag", "doc": "&quot;\n&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


