<?php

/**
 * Show errors at least initially
 *
 * `E_ALL` => for hard dev
 * `E_ALL & ~E_STRICT` => for hard dev in PHP5.4 avoiding strict warnings
 * `E_ALL & ~E_NOTICE & ~E_STRICT` => classic setting
 */
@ini_set('display_errors','1'); @error_reporting(E_ALL);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_STRICT);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

/**
 * Set a default timezone to avoid PHP5 warnings
 */
$dtmz = @date_default_timezone_get();
date_default_timezone_set($dtmz?:'Europe/Paris');

/**
 * For security, transform a realpath as '/[***]/package_root/...'
 *
 * @param string $path
 * @param int $depth_from_root
 *
 * @return string
 */
function _getSecuredRealPath($path, $depth_from_root = 1)
{
    $ds = DIRECTORY_SEPARATOR;
    $parts = explode($ds, realpath('.'));
    for ($i=0; $i<=$depth_from_root; $i++) array_pop($parts);
    return str_replace(join($ds, $parts), $ds.'[***]', $path);
}

/**
 * GET arguments settings
 */
$arg_ln = isset($_GET['ln']) ? $_GET['ln'] : 'en';

function getPhpClassManualLink( $class_name, $ln='en' )
{
    return sprintf('http://php.net/manual/%s/class.%s.php', $ln, strtolower($class_name));
}

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Test & documentation of PHP "Internationalization" package</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="assets/html5boilerplate/css/normalize.css" />
    <link rel="stylesheet" href="assets/html5boilerplate/css/main.css" />
    <script src="assets/html5boilerplate/js/vendor/modernizr-2.6.2.min.js"></script>
	<link rel="stylesheet" href="assets/styles.css" />
</head>
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <header id="top" role="banner">
        <hgroup>
            <h1>Tests of PHP <em>Internationalization</em> package</h1>
            <h2 class="slogan">A PHP package to manage i18n: translations, pluralizations and date and number formats according to a localization.</h2>
        </hgroup>
        <div class="hat">
            <p>These pages show and demonstrate the use and functionality of the <a href="https://github.com/atelierspierrot/internationalization">atelierspierrot/internationalization</a> PHP package you just downloaded.</p>
        </div>
    </header>

	<nav>
		<h2>Map of the package</h2>
        <ul id="navigation_menu" class="menu" role="navigation">
            <li><a href="index.php">Homepage</a><ul>
                <li><a href="index.php#notes">First notes</a></li>
                <li><a href="index.php#tests">Tests & Doc</a></li>
                <li><a href="index.php#options">Loader options</a></li>
                <li><a href="index.php#debug">I18n debug</a></li>
            </ul></li>
            <li><a href="twig.php">Twig extension</a><ul>
                <li><a href="twig.php#twiginclude">Include the extension</a></li>
                <li><a href="twig.php#twigfilters">Filters</a></li>
                <li><a href="twig.php#twigfunctions">Functions</a></li>
                <li><a href="twig.php#twigtags">Tags</a></li>
            </ul></li>
        </ul>

        <div class="info">
            <p><a href="https://github.com/atelierspierrot/internationalization">See online on GitHub</a></p>
            <p class="comment">The sources of this plugin are hosted on <a href="http://github.com">GitHub</a>. To follow sources updates, report a bug or read opened bug tickets and any other information, please see the GitHub website above.</p>
        </div>

    	<p class="credits" id="user_agent"></p>
	</nav>

    <div id="content" role="main">

        <article>

    <h2 id="notes">First notes</h2>
    <p>All these classes works in a PHP version 5.3 minus environment, with the <a href="http://www.php.net/manual/en/book.intl.php">ICU library</a> enabled. They are included in the <em>Namespace</em> <strong>I18n</strong>.</p>
    <p>For clarity, the examples below are NOT written as a working PHP code when it seems not necessary. For example, rather than write <var>echo "my_string";</var> we would write <var>echo my_string</var> or rather than <var>var_export($data);</var> we would write <var>echo $data</var>. The main code for these classes'usage is written strictly.</p>
    <p>As a reminder, and because it's always useful, have a look at the <a href="http://pear.php.net/manual/<?php echo $arg_ln; ?>/standards.php">PHP common coding standards</a>.</p>
    <p>You should exclude <var>E_STRICT</var> error messages from PHP's error reporting.</p>

	<h2 id="tests">Tests & documentation</h2>
    
<h3>Include the <var>I18n</var> namespace</h3>

    <p>As the package classes names are built following the <a href="https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md">PHP Framework Interoperability Group recommandations</a>, we use the <a href="https://gist.github.com/jwage/221634">SplClassLoader</a> to load package classes. The loader is included in the package but you can use your own.</p>

    <pre class="code" data-language="php">
<?php
echo 'require_once ".../src/SplClassLoader.php"; // if required, a copy is proposed in the package'."\n";
echo '$classLoader = new SplClassLoader("I18n", "/path/to/package/src");'."\n";
echo '$classLoader->register();';
?>
    </pre>

    <p>If you use the package in your <a href="http://getcomposer.org/">composer.json</a>, the namespace is automatically added to the autoloader.</p>

    <pre class="code" data-language="php">
<?php
echo 'require_once "vendor/autoload.php";';
?>
    </pre>

    <p>To create an instance of the <var>I18n</var> object, you need to first create a loader:</p>
    
    <pre class="code" data-language="php">
<?php
echo '$i18n_loader = new \I18n\Loader(array('."\n"
    ."\t".'"language_strings_db_directory" => __DIR__."/i18n",'."\n"
    ."\t".'"language_directory" => __DIR__."/i18n",'."\n"
    ."\t".'"force_rebuild" => true,'."\n"
    .'));'."\n";
echo '$translator = \I18n\I18n::getInstance($i18n_loader);'."\n";

require_once '../vendor/autoload.php';
$i18n_loader = new \I18n\Loader(array(
    'language_strings_db_directory'  => __DIR__.'/i18n',
    'language_directory' => __DIR__.'/i18n/%s',
    'force_rebuild' => true,
));
$translator = \I18n\I18n::getInstance($i18n_loader);
/*
echo "\n";
echo 'Dump of the translator object:'."\n";
var_export($translator);
*/
?>
    </pre>

    <p>Have a look is the source code of the Loader for a full review of possible options.</p>

<h3>Include the <var>I18n</var> aliases</h3>

    <p>The package embeds a set of "aliases" functions for quick writing. These functions are not required ...</p>

    <p>To include it:</p>

    <pre class="code" data-language="php">
<?php
echo 'require_once "path/to/I18n-package/src/I18n/aliases.php";';
?>
    </pre>

    <p>As it is declared in the <var>composer.json</var> file, the file will be automatically loaded with the package.</p>
    
    <p>In the examples below, we write both the aliases usage and the procedural style.</p>

<h3>Tests in english</h3>

<p>As english is the default language, no need to declare it ...</p>

<p>The <var>translate</var> basic function:</p>
    <pre class="code" data-language="php">
<?php
echo 'echo _T("test")'."\n";
echo "\t".'or'."\n";
echo 'echo translate("test")'."\n";
echo "\t".'or'."\n";
echo 'echo $translator->translate("test")'."\n";
echo "\n";
echo '=> '._T('test');
?>
    </pre>

<p>The <var>translate</var> function using parameters:</p>
    <pre class="code" data-language="php">
<?php
echo 'echo _T("test_args", , array("arg1"=>"AZERTY", "arg2"=>4.657))'."\n";
echo "\t".'or'."\n";
echo 'echo translate("test_args", , array("arg1"=>"AZERTY", "arg2"=>4.657))'."\n";
echo "\t".'or'."\n";
echo 'echo $translator->translate("test_args", , array("arg1"=>"AZERTY", "arg2"=>4.657))'."\n";
echo "\n";
echo '=> '._T('test_args', array('arg1'=>'AZERTY', 'arg2'=>4.657));
?>
    </pre>

<p>The <var>pluralize</var> function:</p>
    <pre class="code" data-language="php">
<?php
echo '$indexes = array('."\n"
    ."\t".'0=>"test_item_zero",'."\n"
    ."\t".'1=>"test_item_one",'."\n"
    ."\t".'2=>"test_item_two",'."\n"
    ."\t".'3=>"test_item_multi"'."\n"
    .');'."\n";
echo 'echo _P($indexes, number of items)'."\n";
echo "\t".'or'."\n";
echo 'echo pluralize($indexes, number of items)'."\n";
echo "\t".'or'."\n";
echo 'echo $translator->pluralize($indexes, number of items)'."\n";
echo "\n";

$indexes = array(
    0=>'test_item_zero',
    1=>'test_item_one',
    2=>'test_item_two',
    3=>'test_item_multi'
);

for($counter=0; $counter<5; $counter++) {
    echo "\n".'for counter='.$counter.' : '._P($indexes, $counter);
}
?>
    </pre>

<p>The <var>datify</var> or <var>getLocalizedDateString</var> function:</p>
    <pre class="code" data-language="php">
<?php
echo '$date = new \DateTime;'."\n";
echo 'echo _D($date)'."\n";
echo "\t".'or'."\n";
echo 'echo datify($date)'."\n";
echo "\t".'or'."\n";
echo 'echo $translator->getLocalizedDateString($date)'."\n";

echo "\n";
$date = new \DateTime;
echo '=> '._D($date);
?>
    </pre>

<p>The <var>numberify</var> or <var>getLocalizedNumberString</var> function:</p>
    <pre class="code" data-language="php">
<?php
echo '$nb = 19876234234.0987567834;;'."\n";
echo 'echo _N($nb)'."\n";
echo "\t".'or'."\n";
echo 'echo numberify($nb)'."\n";
echo "\t".'or'."\n";
echo 'echo $translator->getLocalizedNumberString($nb)'."\n";
echo "\n";
$nb = 19876234234.0987567834;
echo '=> '._N($nb);
?>
    </pre>

<p>The <var>currencify</var> or <var>getLocalizedPriceString</var> function:</p>
    <pre class="code" data-language="php">
<?php
echo '$nb = 19876234234.0987567834;;'."\n";
echo 'echo _C($nb)'."\n";
echo "\t".'or'."\n";
echo 'echo currencify($nb)'."\n";
echo "\t".'or'."\n";
echo 'echo $translator->getLocalizedPriceString($nb)'."\n";
echo "\n";
$nb = 19876234234.0987567834;
echo '=> '._C($nb);
?>
    </pre>

<p>Some other stuff:</p>
    <pre class="code" data-language="php">
<?php
echo "\n";
echo 'echo $translator->getCurrency()'."\n";
echo '=> '.$translator->getCurrency()."\n";
echo "\n";
echo 'echo $translator->getLanguageCode()'."\n";
echo '=> '.$translator->getLanguageCode()."\n";
echo "\n";
echo 'echo $translator->getLanguageName()'."\n";
echo '=> '.$translator->getLanguageName()."\n";
echo "\n";
echo 'echo $translator->getCountryName()'."\n";
echo '=> '.$translator->getCountryName()."\n";
echo "\n";
echo 'echo $translator->getCountryName("fr")'."\n";
echo '=> '.$translator->getCountryName('fr')."\n";
echo "\n";
echo 'echo $translator->getLocaleScript("fr")'."\n";
echo '=> '.$translator->getLocaleScript('fr')."\n";
echo "\n";
echo 'echo $translator->getLocaleVariant()'."\n";
echo '=> '.$translator->getLocaleVariant()."\n";
echo "\n";
echo 'echo $translator->getLocaleVariant("fr")'."\n";
echo '=> '.$translator->getLocaleVariant('fr')."\n";
?>
    </pre>

    <h3>Same tests in french</h3>

<p>To change the language, you can pass its code at last argument of each functions used
above, or define it globally using:</p>

    <pre class="code" data-language="php">
<?php
echo 'echo $translator->setLanguage("fr")'."\n";
?>
    </pre>

<p>Below are the results of each tests above using 'fr' language:</p>
    <pre class="code" data-language="php">
<?php
echo '=> '._T('test', null, 'fr');

echo "\n";
echo "\n";
echo '=> '._T('test_args', array('arg1'=>'AZERTY', 'arg2'=>4.657), 'fr');

echo "\n";
$indexes = array(
    0=>'test_item_zero',
    1=>'test_item_one',
    2=>'test_item_two',
    3=>'test_item_multi'
);
for($counter=0; $counter<5; $counter++) {
    echo "\n".'for counter='.$counter.' : '._P($indexes, $counter, null, 'fr');
}

echo "\n";
echo "\n";
echo '=> '._D($date, null, 'UTF-8', 'fr');

echo "\n";
echo "\n";
echo '=> '._N($nb, 'fr');

echo "\n";
echo "\n";
echo '=> '._C($nb, 'fr');

echo "\n";
echo "\n";
echo 'echo $translator->getCurrency("fr")'."\n";
echo '=> '.$translator->getCurrency('fr')."\n";
echo 'echo $translator->getLanguageCode("fr")'."\n";
echo '=> '.$translator->getLanguageCode('fr')."\n";
echo 'echo $translator->getLanguageName("fr","fr")'."\n";
echo '=> '.$translator->getLanguageName('fr','fr')."\n";
echo 'echo $translator->getLanguageName("en","fr")'."\n";
echo '=> '.$translator->getLanguageName('en','fr')."\n";
echo 'echo $translator->getCountryName("fr","fr")'."\n";
echo '=> '.$translator->getCountryName('fr','fr')."\n";
echo 'echo $translator->getCountryName("en","fr")'."\n";
echo '=> '.$translator->getCountryName('en','fr')."\n";
echo 'echo $translator->getLocaleScript("en", "fr")'."\n";
echo '=> '.$translator->getLocaleScript('en', 'fr')."\n";
echo 'echo $translator->getLocaleVariant("fr")'."\n";
echo '=> '.$translator->getLocaleVariant('fr')."\n";
echo 'echo $translator->getLocaleVariant("en","fr")'."\n";
echo '=> '.$translator->getLocaleVariant('en','fr')."\n";
?>
    </pre>

    <h2 id="options">Loader options</h2>

    <h3>Available languages</h3>

<p>The <var>available_languages</var> array defines a key=>value pairs table of the locales and languages you want to use. 
For each case, the key is the shortcut used to identify the language (<em><var>en</var> for US english for example</em>) and the
value is a full locale code, constructed as <var>[language code]_[country code]_[variant]</var>, as defined in the <a href="http://userguide.icu-project.org/locale">ICU Locale naming conventions</a>.
You can define your locale codes with more complex informations such as keywords or scripts, but the three informations <var>language code</var>, <var>country code</var> and <var>variant</var> are required
to use all the <var>I18n</var> methods. In our case, the <var>variant</var> is the currency.
</p>

    <pre class="code" data-language="php">
<?php
echo 'array ('."\n"
    ."\t".'"en" => "en_US_USD",'."\n"
    ."\t".'"gb" => "en_GB_UKP",'."\n"
    ."\t".'"fr" => "fr_FR_EUR",'."\n"
.')';
?>
    </pre>

<p>You can retrieve the full table of available languages and corresponding locales with:</p>

    <pre class="code" data-language="php">
<?php
echo 'echo $translator->getAvailableLanguages()'."\n";
echo '=> '.var_export($translator->getAvailableLanguages(),1)."\n";
echo "\n";
echo 'echo $translator->getAvailableLanguagesNames()'."\n";
echo '=> '.var_export($translator->getAvailableLanguagesNames(),1)."\n";
echo "\n";
echo 'echo $translator->getAvailableLanguagesNames("fr")'."\n";
echo '=> '.var_export($translator->getAvailableLanguagesNames('fr'),1)."\n";
?>
    </pre>

    <h3>Show untranslated</h3>

<p>Set the <var>show_untranslated</var> option to <var>true</var> to see the strings called for translation by that doesn't seem to exist (<em>for debug</em>).</p>

    <pre class="code" data-language="php">
<?php
echo '$translator->getLoader()->setOption("show_untranslated", true);'."\n";
echo 'echo _T("noexist", array('."\n"
    ."\t".'"argument"=>"myqsdf jqsmdlkfj JKmlkqsjdf qmsldkfj",'."\n"
    ."\t".'"other arg"=>1.2376,'."\n"
    ."\t".'"array arg"=>array(23, 34, 897, "abc"),'."\n"
    ."\t".'"object arg"=>new StdClass"'."\n"
    .'));';
?>
    </pre>
<p>Will render:</p>
<p>
<?php
$translator->getLoader()->setOption('show_untranslated', true);
echo '=> '._T('noexist', array(
    'argument'=>'myqsdf jqsmdlkfj JKmlkqsjdf qmsldkfj',
    'other arg'=>1.2376,
    'array arg'=>array(23, 34, 897, 'abc'),
    'object arg'=>new StdClass
));
?>
</p>

    <h3>Accept from HTTP</h3>

<p>To let the class get and use the browser locale if so:</p>

    <pre class="code" data-language="php">
<?php
echo '$translator->setDefaultFromHttp();'."\n";
?>
    </pre>

    <h2 id="debug">I18n debug</h2>

    <p>Finally, a full dump of the <var>translator</var> object used in this page:</p>
    
    <pre class="code" data-language="php">
<?php
var_export($translator);
?>
    </pre>

<?php
/*
echo "\n\n";
echo _T('Test of non-indexed string')."\n";
echo _T('Test of non-indexed string',null,'fr')."\n";
echo "\n\n";
echo _T('html_test')."\n";
echo _T('html_test',null,'fr')."\n";
*/
?>

        </article>
    </div>

    <footer id="footer">
		<div class="credits float-left">
		    This page is <a href="" title="Check now online" id="html_validation">HTML5</a> & <a href="" title="Check now online" id="css_validation">CSS3</a> valid.
		</div>
		<div class="credits float-right">
		    <a href="https://github.com/atelierspierrot/internationalization">atelierspierrot/internationalization</a> package by <a href="https://github.com/PieroWbmstr">Piero Wbmstr</a> under <a href="http://opensource.org/licenses/GPL-3.0">GNU GPL v.3</a> license.
		</div>
    </footer>

    <div class="back_menu" id="short_navigation">
        <a href="#" title="See navigation menu" id="short_menu_handler"><span class="text">Navigation Menu</span></a>
        &nbsp;|&nbsp;
        <a href="#top" title="Back to the top of the page"><span class="text">Back to top&nbsp;</span>&uarr;</a>
        <ul id="short_menu" class="menu" role="navigation"></ul>
    </div>

    <div id="message_box" class="msg_box"></div>

<!-- jQuery lib -->
<script src="assets/js/jquery-1.9.1.min.js"></script>

<!-- HTML5 boilerplate -->
<script src="assets/html5boilerplate/js/plugins.js"></script>

<!-- jQuery.highlight plugin -->
<script src="assets/js/highlight.js"></script>

<!-- scripts for demo -->
<script src="assets/scripts.js"></script>

<script>
$(function() {
    initBacklinks();
    activateMenuItem();
    getToHash();
    buildFootNotes();
    addCSSValidatorLink('assets/styles.css');
    addHTMLValidatorLink();
    $("#user_agent").html( navigator.userAgent );
    $('pre.code').highlight({source:0, indent:'tabs', code_lang: 'data-language'});
});
</script>
</body>
</html>
