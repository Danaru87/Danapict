<?php

require_once("data.class.php");
require_once("user.class.php");
session_start();
$data = new Data();

if ($_POST["nomutilisateur"] == "" || $_POST["pwd"] == "")
{
	$_SESSION["erreur"] = "Vous devez saisir un login / mot de passe !";
	header ("Location: ../index.php");
	
}
else
{
	$user = new User();
	$user = $data->Loggin($_POST["nomutilisateur"], $_POST["pwd"]);
	if ($user == null)
	{
		$_SESSION["erreur"] = "Login / Mot de Passe incorrect(s) !".$user;
		header ("Location: ../index.php");
	}
	else
	{
		$_SESSION["user"] = $user;
		header ("Location: ../gestion.php");
	}
}
?>