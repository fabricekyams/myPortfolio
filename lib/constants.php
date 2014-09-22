<?php

define('ROOT', (dirname(dirname(__FILE__))));
$dir = basename(ROOT);
$url = explode($dir, $_SERVER['REQUEST_URI']);
if (count($url)==1){
	define('WEBROOT', '/');
}else {
	define('WEBROOT',$url[0].$dir.'/');
}

define('IMAGE', ROOT . DIRECTORY_SEPARATOR . 'img/');

var_dump('__FILE__: '.__FILE__);
var_dump('basename ROOT: '.$dir);
var_dump('ROOT: '.ROOT);
var_dump('WEBROOT: '.WEBROOT);
var_dump('IMAGE: '.IMAGE);


//define('WEBROOT', dirname($_SERVER['SCRIPT_NAME']).'/');
