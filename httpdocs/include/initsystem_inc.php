<?php

# Set up our own custom error handler
function customErrorHandler($errno, $errstr, $errfile, $errline, array $errcontext)
{
    // error was suppressed with the @-operator
    if (0 === error_reporting()) { return false; }
    
    switch ($errno) {    
        case E_ERROR:
        case E_USER_ERROR:
            error_log(sprintf("ERROR [%s] %s  Fatal error on line %s in file %s",$errno,$errstr,$errline,$errfile));
            exit(1);
            break;
        case E_WARNING:
        case E_USER_WARNING:
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            break;
        case E_NOTICE:
        case E_USER_NOTICE:
            error_log(sprintf("NOTICE [%s] %s  Error on line %s in file %s",$errno,$errstr,$errline,$errfile));
            break;
        default:
            error_log(sprintf("ERROR [%s] %s  Unknown error type on line %s in file %s",$errno,$errstr,$errline,$errfile));
            break;
    } 
}

set_error_handler('customErrorHandler');

// This sets our API version
define("LATEST_API_VERSION","1.0");
$apiVersion = (isset($_SERVER['REQUEST_URI']) && preg_match("|api/(.*?)/|", $_SERVER['REQUEST_URI'], $matches) && $matches[1]) ? $matches[1] : LATEST_API_VERSION;

// Set up some environmental variables to assis class loading
if(!($_SERVER['DOCUMENT_ROOT'])) { $_SERVER['DOCUMENT_ROOT']=realpath(sprintf("%s/../", dirname(__FILE__))); }
define("PROMPT_INCLUDE_PATH",realpath(sprintf("%s/include", $_SERVER['DOCUMENT_ROOT'])));
define("PROMPT_CLASSES_PATH",sprintf('%s/include/classes/',$_SERVER['DOCUMENT_ROOT']));
define("API_VERSION",$apiVersion);
set_include_path(sprintf("%s%s%s",get_include_path(),PATH_SEPARATOR, PROMPT_CLASSES_PATH));

// Install our Composer autoloader
require_once(sprintf("%s/include/vendor/autoload.php", $_SERVER['DOCUMENT_ROOT']));

// We need to play nicely with composer whilst still using our own autoloader 
function customCIAutoload($class)
{
 if(strpos($class, 'CI_') !== 0)
 {    
    $file=sprintf("%s.php", str_replace('\\','/',$class));
    // Inject API version
    $file = preg_replace('/^(.*?\/)/', sprintf('$1v%s/', API_VERSION), $file);
    if(!@include_once($file)) {
        throw new \Exception(sprintf("Unable to load file %s",$file));
    }
 }
}
spl_autoload_register('customCIAutoload');

// Set up out default timezone. UTC is generally the best option.
$timezone = "UTC";
date_default_timezone_set($timezone);
ini_set("date.timezone", $timezone); # Needed for Google API's

// We can access config variables via the BotConfig() class
$ServiceConfig = new \Bot\Config\BotConfig();

// Put some constants in the global scope. Some prompt-lib functions rely on these.
define("BOT_ENVIRONMENT", $ServiceConfig->getValue("BOT_ENVIRONMENT"));
define("MYSQL_CHARSET","utf8");
define("MYSQL_DATE_FORMAT", "Y-m-d");
define("MYSQL_DATETIME_FORMAT", "Y-m-d H:i:s");
define("TIMEZONE_SYSTEM",$timezone);

// If this is the development environment, lets see all those bugs...
if(BOT_ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set('display_errors','on');
}