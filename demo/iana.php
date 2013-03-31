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
            <h1>Working round the IANA database</h1>
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

<?php
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

    <pre class="code" data-language="php">
<?php

$iana = new \I18n\Iana(null, __DIR__);
$db = $iana->getDb();

//var_export($iana->getLanguages());
//var_export($iana->getRegions());
//var_export($iana->getScripts());
var_export($iana->getExtlangs());

var_export(array_keys($db));
//var_export($db);

echo '=> '.$translator->getCurrency()."\n";
echo '=> '.$translator->getCurrency('fr')."\n";
echo '=> '.$translator->getLocalizedNumberString(1234234.0987567834)."\n";
echo '=> '.$translator->getLocalizedNumberString(1234234.0987567834, 'fr')."\n";
echo '=> '.$translator->getLocalizedPriceString(1234234.0987567834)."\n";
echo '=> '.$translator->getLocalizedPriceString(123423.0987567834, 'fr')."\n";
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
