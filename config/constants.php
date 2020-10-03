<?php 
namespace config;

define("ROOT", dirname(__DIR__));
define("DS", "/");

define("FRONT_ROOT", "/Laboratorio/moviepass git/");

define("VIEWS_PATH", "views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");

include_once('auth.php');
?>