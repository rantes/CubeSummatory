<?php
define('INST_PATH', dirname(dirname(__FILE__)).'/');
define( 'INST_URI', 'http://cubesumation.local/' ); // SIEMPRE DEBE LLEVAR SLASH AL FINAL
define('SITE_STATUS','LIVE'); //status of the page: LIVE MAINTENANCE
define('LANDING_PAGE','index/landing'); //landing page
define('LANDING_REPLACE','ALL'); //instead of these pages, show landing ALL or comma separated | index/index,index/another,index/contact

define('DEF_CONTROLLER', 'index'); //default controller/
define('DEF_ACTION', 'index'); //default view/
define('USE_ALTER_URL', true);
define('ALTER_URL_CONTROLLER_ACTION','index/router');

ini_set('display_errors', 1);
ini_set('max_execution_time',0);
set_time_limit(0);
ini_set('upload_tmp_dir', INST_PATH.'app/webroot/uploaded');

error_reporting(E_ALL);

date_default_timezone_set('America/Bogota');
$GLOBALS['env'] = 'dev';
?>
