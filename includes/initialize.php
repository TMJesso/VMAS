<?php

// define the core paths
// define them as absolute paths to make sure that require_once
// works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
$host = gethostname();
$t9 = "jcservices-vmas-448050";
$c9 = "heinzerware-fair-4303040";

defined('SITE_ROOT') 	? null : define('SITE_ROOT', substr($_SERVER["DOCUMENT_ROOT"],2,strlen($_SERVER["DOCUMENT_ROOT"])).(($host != $t9 || $host != $c9) ? "vmas/" : "") );

defined('SITE_HTTP') 	? null : define('SITE_HTTP', "../");

defined('LIB_PATH') 	? null : define('LIB_PATH', SITE_ROOT."includes/");
defined('LIB_BACK') 	? null : define('LIB_BACK', SITE_ROOT."backup/");
defined('LIB_LAYOUT') 	? null : define('LIB_LAYOUT', SITE_ROOT."public/layout/");
defined('JS_PATH') 		? null : define('JS_PATH', SITE_HTTP."js/");
defined('CSS_PATH') 	? null : define('CSS_PATH', SITE_HTTP."css/");
defined('HEAD_PATH') 	? null : define('HEAD_PATH', SITE_ROOT."vmas/public/layout/");
defined('IMG_PATH') 	? null : define("IMG_PATH", SITE_HTTP.'img/');
//D:\wamp\www\vmas\public\js
// Load config file first
require_once(LIB_PATH.'/config.php');

// load basic functions next so that everything after can them
require_once(LIB_PATH.'/vmasfunc.php');

// load core objects
require_once(LIB_PATH.'/session.php');
require_once(LIB_PATH.'/database_object.php');
require_once(LIB_PATH.'/database.php');
// require_once(LIB_PATH.DS."phpMailer".DS."class.phpmailer.php");
// require_once(LIB_PATH.DS."phpMailer".DS."class.smtp.php");
// require_once(LIB_PATH.DS."phpMailer".DS."language".DS."phpmailer.lang-en.php");

// Load database-related classes
// require_once(LIB_PATH.'/user.php');
require_once(LIB_PATH.'/menu.php');
require_once(LIB_PATH.'/submenu.php');
require_once(LIB_PATH.'/subsubmenu.php');
require_once(LIB_PATH.'/log.php');
require_once(LIB_PATH.'/vehicle.php');
// require_once(LIB_PATH.'/pages.php');
// require_once(LIB_PATH.'/subjects.php');
// require_once(LIB_PATH.'/photo.php');


?>