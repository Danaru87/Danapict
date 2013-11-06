<?php
	require_once('../class/bdd.fn.php');
if (!isset($_POST))
{
	header('location: ../index.php');
}
else
{
	$loggin = $_POST['loggin'];
	$pass = $_POST['pass'];
	$db = Connect() or die ("Impossible de se connecter a la base de donnee, veuillez verifier vos informations dans le fichier bdd.fn.php");

	//Creation des tables dans la BDD
	// Table contenant les informations d'image
	$request = "CREATE TABLE IF NOT EXISTS `pictures` 
					(
					`id` int(1) NOT NULL AUTO_INCREMENT,
  					`titre` text NOT NULL,
  					`description` text,
  					`url` text NOT NULL,
  					`urlMini` text NOT NULL,
 					`visible` tinyint(1) NOT NULL,
  					PRIMARY KEY (`id`)
					) 
					ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
	$db->query($request) or die ("Erreur dans la requete de création de table Picture");

	// Table Contenant les informations utilisateur
	$request = "CREATE TABLE IF NOT EXISTS `user` 
							(
  								`loggin` text NOT NULL,
  								`mdp` text NOT NULL
							) 
							ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$db->query($request) or die("Erreur dans la requete de creation de table User");

	// Creation de l'utilisateur dans la BDD
	$request = "INSERT INTO user (loggin, mdp) VALUES ('".$loggin."', '".$pass."')";
	$result = $db->query($request) or die ("Erreur dans la requete de création loggin motdepasse");
	unlink ("bdd.install.php");
	unlink("index.php");
	unlink("loggin.php");
	unlink("install.fn.php");
	rmdir('../install/');
	header ("location: ../index.php");
}
?>