<?php
	function Connect()
	{
	$host =''; 
	$user ='';  
	$pass = ''; 
	$base ='';
	$db = new mysqli ($host, $user, $pass, $base); 
	return $db; 
	}
	?>
