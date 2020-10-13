<?php
 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	
	require "config/autoload.php";
	require "config/constants.php";

	use config\autoload as Autoload;
	use config\router 	as Router;
	use config\request 	as Request;
		
	Autoload::start();

	session_start();

	Router::route(new Request());


?>