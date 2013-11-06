<?php
	if (!isset($_POST['bdd']))
	{
		$bdd ="";
	}
	else
	{
		$bdd = $_POST['bdd'];
	}
	$localhost = $_POST['localhost'];
	$logbdd = $_POST['logbdd'];
	$passbdd = $_POST['passbdd'];
	//Mofification du fichier ../class/bdd.fn.php
	$file = fopen('../class/bdd.fn.php', 'w');
	fseek($file, 0);
	$modif = '<?php
	function Connect()
	{
	$host =\''.$localhost.'\'; 
	$user =\''.$logbdd.'\';  
	$pass = \''.$passbdd.'\'; 
	$base =\''.$bdd.'\';
	$db = new mysqli ($host, $user, $pass, $base); 
	return $db; 
	}
	?>';
	
	fputs($file, $modif);
	header("location: ./loggin.php");
?>