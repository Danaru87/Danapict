<?php
	function Connect()
	{
	$host ='mysql51-89.perso'; 
	$user ='othenticdanapict';  
	$pass = '0150zc41'; 
	$base ='othenticdanapict';
	$db = new mysqli ($host, $user, $pass, $base); 
	return $db; 
	}
	?>