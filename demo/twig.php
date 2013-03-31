<?php

// show errors at least initially
@ini_set('display_errors','1'); @error_reporting(E_ALL ^ E_NOTICE);

// set a default timezone to avoid PHP5 warnings
$dtmz = date_default_timezone_get();
date_default_timezone_set( !empty($dtmz) ? $dtmz:'Europe/Paris' );

// arguments settings
$arg_dir = isset($_GET['dir']) ? rtrim($_GET['dir'], '/').'/' : 'parts/';
$arg_root = isset($_GET['root']) ? $_GET['root'] : __DIR__;
$arg_i = isset($_GET['i']) ? $_GET['i'] : 0;
$arg_ln = isset($_GET['ln']) ? $_GET['ln'] : 'en';

// for security
function _getSecuredRealPath( $str )
{
    $parts = explode('/', realpath('.'));
    array_pop($parts);
    array_pop($parts);
    return str_replace(join('/', $parts), '/[***]', $str);
}

function getPhpClassManualLink( $class_name, $ln='en' )
{
    return sprintf('http://php.net/manual/%s/class.%s.php', $ln, strtolower($class_name));
}

require_once '../vendor/autoload.php';
$i18n_loader = new \I18n\Loader(array(
    'language_strings_db_directory'  => __DIR__.'/i18n',
    'language_directory' => __DIR__.'/i18n/%s',
    'force_rebuild' => true,
));
$translator = \I18n\I18n::getInstance($i18n_loader);

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
            <h1>TWIG extension included in the PHP <em>Internationalization</em> package</h1>
            <h2 class="slogan">A PHP package to manage i18n: translations, pluralizations and date formats according to a localization.</h2>
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

	<h2 id="twig">Twig extension</h2>

<p>The package includes a Twig extension to use the <var>translate</var>, <var>pluralize</var> and <var>datify</var> functions described above in the template engine.</p>

	<h3 id="twiginclude">Include the extension</h3>

<p>First, you need to setup your I18n instance:</p>

    <pre class="code" data-language="php">
<?php
echo 'require_once "vendor/autoload.php";';
echo "\n\n\tor\n\n";
echo 'require_once ".../src/SplClassLoader.php"; // if required, a copy is proposed in the package'."\n";
echo '$classLoader = new SplClassLoader("I18n", "/path/to/package/src");'."\n";
echo '$classLoader->register();';
echo "\n\n";
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
?>
    </pre>

<p>Then, you need to add the I18n extension:</p>

    <pre class="code" data-language="php">
<?php
if (!class_exists('Twig_Loader_String')) {
    echo 'You need to include Twig in your autoloader to visualize the tests ...'."\n\n";
    echo 'You can run:'."\n\t".'~$ composer update --dev';
}

echo '$loader = new Twig_Loader_String();'."\n";
echo '$twig = new Twig_Environment($loader);'."\n";
echo '$twig->addExtension(new \I18n\Twig\Extension($translator));'."\n";

$loader = new Twig_Loader_String();
$twig = new Twig_Environment($loader);
$twig->addExtension(new \I18n\Twig\I18nExtension($translator));
//define("I18N_TWIGTAGS_DEBUG", true);
?>
    </pre>

	<h3 id="twigglobals">Globals</h3>

<p>The extension loads in Tiwg the global <var>i18n</var> which is the instance itself. This way, you can access some of its methods:</p>

    <pre class="code" data-language="php">
<?php
echo "\n";
echo 'echo $twig->render("{{ i18n.locale }}")'."\n";
echo '=> '.$twig->render("{{ i18n.locale }}")."\n";
echo "\n";
echo 'echo $twig->render("{{ i18n.language }}")'."\n";
echo '=> '.$twig->render("{{ i18n.language }}")."\n";
echo "\n";
echo 'echo $twig->render("{% for _ln in i18n.availableLanguages %} {{ _ln }} {% endfor %}")'."\n";
echo '=> '.$twig->render("{% for _ln in i18n.availableLanguages %} {{ _ln }} {% endfor %}")."\n";
?>
    </pre>

	<h3 id="twigfilters">Filters</h3>

    <pre class="code" data-language="php">
<?php
echo "\n";
echo 'echo $twig->render("Hello {{ name }}! {{ \'test\'|translate }}", array(name => PieroWbmstr));'."\n";
echo '=> '.$twig->render("Hello {{ name }}! {{ 'test'|translate }}", array('name' => 'PieroWbmstr'))."\n";
echo "\n";
echo 'echo $twig->render("Hello {{ name }}! {% set args={"arg1":"AZERTY", "arg2":4.657} %}{{ "test_args"|translate(args) }}", array(name => PieroWbmstr));'."\n";
echo '=> '.$twig->render("Hello {{ name }}! {% set args={'arg1':'AZERTY', 'arg2':4.657} %}{{ 'test_args'|translate(args) }}", array('name' => 'PieroWbmstr'))."\n";
echo "\n";
echo 'echo $twig->render("Hello {{ name }}! {{ "test_args"|translate({}, "fr") }}", array(name => PieroWbmstr));'."\n";
echo '=> '.$twig->render("Hello {{ name }}! {{ 'test'|translate({}, 'fr') }}", array('name' => 'PieroWbmstr'))."\n";

$date = new \DateTime();
echo "\n";
echo '$date = new DateTime;'."\n";
echo 'echo $twig->render("Hello {{ name }}! {{ date|datify }}", array(name => PieroWbmstr, date => $date));'."\n";
echo '=> '.$twig->render("Hello {{ name }}! {{ date|datify }}", array('name' => 'PieroWbmstr', 'date'=>$date))."\n";
?>
    </pre>

	<h3 id="twigfunctions">Functions</h3>

    <pre class="code" data-language="php">
<?php
echo "\n";
echo 'echo $twig->render("Hello {{ name }}! {{ translate(\'test\') }}", array(name => PieroWbmstr));'."\n";
echo '=> '.$twig->render("Hello {{ name }}! {{ translate('test') }}", array('name' => 'PieroWbmstr'))."\n";
echo "\n";
echo 'echo $twig->render("Hello {{ name }}! {{ translate(\'test_args\', {"arg1":"AZERTY", "arg2":4.657}) }}", array(name => PieroWbmstr));'."\n";
echo '=> '.$twig->render("Hello {{ name }}! {{ translate('test_args', {'arg1':'AZERTY', 'arg2':4.657}) }}", array('name' => 'PieroWbmstr'))."\n";
echo "\n";
echo 'echo $twig->render("Hello {{ name }}! {{ translate(\'test\', {}, "fr") }}", array(name => PieroWbmstr));'."\n";
echo '=> '.$twig->render("Hello {{ name }}! {{ translate('test', {}, 'fr') }}", array('name' => 'PieroWbmstr'))."\n";
echo "\n";
echo 'echo $twig->render("Hello {{ name }}! {{ pluralize([\'test_item_zero\',\'test_item_one\',\'test_item_two\',\'test_item_multi\'], 0) }}", array(name => PieroWbmstr));'."\n";
echo '=> '.$twig->render("Hello {{ name }}! {{ pluralize(['test_item_zero','test_item_one','test_item_two','test_item_multi'], 0) }}", array('name' => 'PieroWbmstr'))."\n";
echo "\n";
echo 'echo $twig->render("Hello {{ name }}! {{ pluralize([\'test_item_zero\',\'test_item_one\',\'test_item_two\',\'test_item_multi\'], 1) }}", array(name => PieroWbmstr));'."\n";
echo '=> '.$twig->render("Hello {{ name }}! {{ pluralize(['test_item_zero','test_item_one','test_item_two','test_item_multi'], 1) }}", array('name' => 'PieroWbmstr'))."\n";
echo "\n";
echo 'echo $twig->render("Hello {{ name }}! {{ pluralize([\'test_item_zero\',\'test_item_one\',\'test_item_two\',\'test_item_multi\'], 4) }}", array(name => PieroWbmstr));'."\n";
echo '=> '.$twig->render("Hello {{ name }}! {{ pluralize(['test_item_zero','test_item_one','test_item_two','test_item_multi'], 4) }}", array('name' => 'PieroWbmstr'))."\n";
$date = new \DateTime();
echo "\n";
echo '$date = new DateTime;'."\n";
echo 'echo $twig->render("Hello {{ name }}! {{ datify(date) }}", array(name => PieroWbmstr, date => $date));'."\n";
echo '=> '.$twig->render("Hello {{ name }}! {{ datify(date) }}", array('name' => 'PieroWbmstr', 'date'=>$date))."\n";
?>
    </pre>

	<h3 id="twigtags">Tags</h3>

<p>Use the following to debug tags:</p>

    <pre class="code" data-language="php">
<?php
echo 'define("I18N_TWIGTAGS_DEBUG", true);';
?>
    </pre>

	<h4>The "translate" tag</h4>
	
<p>You can use the translate tag in different ways:</p>

    <pre class="code" data-language="php">
{% translate %}
    string to translate
{% endtranslate %}
    OR
{% translate "string to translate" %}

{% translate {arguments} %}
    string to translate
{% endtranslate %}
    OR
{% translate {arguments} "string to translate" %}

{% translate 'ln' %}
    string to translate
{% endtranslate %}
    OR
{% translate 'ln' "string to translate" %}

{% translate 'ln' {arguments} %}
    string to translate
{% endtranslate %}
    OR
{% translate 'ln' {arguments} "string to translate" %}
    </pre>

<p>Demonstrations:</p>

    <pre>
<?php
$str1 = <<<EOT

This is a test for the "translate" Twig tag.

{% translate "test" %}

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

EOT;

$str2 = <<<EOT

This is a test for the "translate" Twig tag.

{% translate %}
test
{% endtranslate %}

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

EOT;

$str3 = <<<EOT

This is a test for the "translate" Twig tag.

{% translate 'fr' %}
test
{% endtranslate %}

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

EOT;

$str4 = <<<EOT

This is a test for the "translate" Twig tag.

{% translate { 'arg1': 'AZERTY', 'arg2': 4.657} %}
test_args
{% endtranslate %}

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

EOT;

$str5 = <<<EOT

This is a test for the "translate" Twig tag.

{% translate "fr" { 'arg1': 'AZERTY', 'arg2': 4.657} %}
test_args
{% endtranslate %}

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

EOT;

$str6 = <<<EOT

This is a test for the "translate" Twig tag.

{% translate "test_args" "fr" { 'arg1': 'AZERTY', 'arg2': 4.657} %}

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

EOT;

echo $str1."\n";
echo '=> '.$twig->render($str1)."\n";
echo "<hr />\n";
echo $str2."\n";
echo '=> '.$twig->render($str2)."\n";
echo "<hr />\n";
echo $str3."\n";
echo '=> '.$twig->render($str3)."\n";
echo "<hr />\n";
echo $str4."\n";
echo '=> '.$twig->render($str4)."\n";
echo "<hr />\n";
echo $str5."\n";
echo '=> '.$twig->render($str5)."\n";
echo "<hr />\n";
echo $str6."\n";
echo '=> '.$twig->render($str6)."\n";

?>
    </pre>

	<h4>The "pluralize" tag</h4>
	
<p>You can use it in different ways:</p>

    <pre class="code" data-language="php">
{% pluralize number %}
    test_item_zero|test_item_one | test_item_two| test_item_multi
{% endpluralize %}

{% pluralize number {arguments} %}
    test_item_zero|test_item_one | test_item_two| test_item_multi
{% endpluralize %}

{% pluralize number 'ln' %}
    test_item_zero|test_item_one | test_item_two| test_item_multi
{% endpluralize %}

{% pluralize number 'ln' {arguments} %}
    test_item_zero|test_item_one | test_item_two| test_item_multi
{% endpluralize %}
    </pre>

<p>Demonstrations:</p>

    <pre>
<?php
$str1 = <<<EOT

This is a test for the "translate" Twig tag.

{% pluralize 0 %}
    test_item_zero|test_item_one | test_item_two| test_item_multi
{% endpluralize %}

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

EOT;

$str3 = <<<EOT

This is a test for the "translate" Twig tag.

{% pluralize 2 'fr' %}
    test_item_zero|test_item_one | test_item_two| test_item_multi
{% endpluralize %}

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

EOT;

$str4 = <<<EOT

This is a test for the "translate" Twig tag.

{% pluralize 0 { 'arg1': 'AZERTY', 'arg2': 4.657} %}
    test_item_zero_args|test_item_one_args | test_item_two_args| test_item_multi_args
{% endpluralize %}

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

EOT;

$str5 = <<<EOT

This is a test for the "translate" Twig tag.

{% pluralize 2 "fr" { 'arg1': 'AZERTY', 'arg2': 4.657} %}
    test_item_zero_args|test_item_one_args | test_item_two_args| test_item_multi_args
{% endpluralize %}

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

EOT;

echo $str1."\n";
echo '=> '.$twig->render($str1)."\n";
echo "<hr />\n";
echo $str3."\n";
echo '=> '.$twig->render($str3)."\n";
echo "<hr />\n";
echo $str4."\n";
echo '=> '.$twig->render($str4)."\n";
echo "<hr />\n";
echo $str5."\n";
echo '=> '.$twig->render($str5)."\n";
?>
    </pre>

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
