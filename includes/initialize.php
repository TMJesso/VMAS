<?php

// define the core paths
// define them as absolute paths to make sure that require_once
// works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
$host = gethostname();
$t9 = "jcservices-vmas-4694685";


defined('SITE_ROOT') 	? null : define('SITE_ROOT', $_SERVER["DOCUMENT_ROOT"] . DS . "VMAS" . DS);

defined('SITE_HTTP') 	? null : define('SITE_HTTP', DS . "VMAS" . DS);

defined('LIB_PATH') 	? null : define('LIB_PATH', SITE_ROOT."includes" . DS);
defined('LIB_BACK') 	? null : define('LIB_BACK', SITE_ROOT."backup" . DS);
defined('LIB_LAYOUT') 	? null : define('LIB_LAYOUT', SITE_ROOT."public" . DS . "layout" . DS);
defined('JS_PATH') 		? null : define('JS_PATH', SITE_HTTP."public" . DS . "js" . DS);
defined('CSS_PATH') 	? null : define('CSS_PATH', SITE_HTTP."public" . DS . "css" . DS);
defined('HEAD_PATH') 	? null : define('HEAD_PATH', SITE_ROOT."public" . DS . "layout" . DS);
defined('IMG_PATH') 	? null : define("IMG_PATH", SITE_HTTP."public" . DS . "img" . DS);
//D:\wamp\www\vmas\public\js
// Load config file first
require_once LIB_PATH.'config.php';

// load basic functions next so that everything after can them
require_once LIB_PATH.'vmasfunc.php';

// load core objects
require_once LIB_PATH.'session.php';
require_once LIB_PATH.'database_object.php';
require_once LIB_PATH.'database.php';
// require_once LIB_PATH.DS."phpMailer".DS."class.phpmailer.php");
// require_once LIB_PATH.DS."phpMailer".DS."class.smtp.php");
// require_once LIB_PATH.DS."phpMailer".DS."language".DS."phpmailer.lang-en.php");

// Load database-related classes
// require_once LIB_PATH.'/user.php';
require_once LIB_PATH.'menu.php';
require_once LIB_PATH.'submenu.php';
require_once LIB_PATH.'subsubmenu.php';
require_once LIB_PATH.'log.php';
require_once LIB_PATH.'vehicle.php';
require_once LIB_PATH.'dealer.php';
require_once LIB_PATH . 'org.php';
// require_once LIB_PATH.'/pages.php';
// require_once LIB_PATH.'/subjects.php';
// require_once LIB_PATH.'/photo.php';


?>