<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pstone
 * Date: 3/18/13
 * Time: 8:53 PM
 * This is a bootstrap file
 */

// define constants
define('BASEDIR', dirname (__FILE__));
define('WEBBASEDIR', 'su.local');


// database setting
define('DB_HOST', 'localhost');
define('DB_NAME', 'su');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');

// csv file setting
// @todo: write a function that reads every file in the urls folder
define ('DATASOURCES',
    serialize (
        array('free411.com', 'gigaom.com', 'hubspot.com', 'leadertoleader.org', 'simplyexplained.com')
    )
    );

/**
 * @param $class_name
 * AUTOLOAD any class in "classes" folder
 */
function __autoload($class_name) {
    $file = BASEDIR.'/classes/'.$class_name.'.php';
    if (!file_exists ($file) )
    {
        echo 'Requested module '.$class_name.' is missing.';
		exit();
	}
    require_once($file);
}

// route urls to php file
if (empty($_GET['route']) ) $route = 'index'; else $route = $_GET['route'];

$parts = explode('/', $route);

if(count($parts)>0)
{
    $class = $parts[0];
    $action = $parts[1];

    //can only send one argument at this point
    //@todo accept more
    $args = $parts[2];

    $class = new $class();
    $class->$action($args);
}

