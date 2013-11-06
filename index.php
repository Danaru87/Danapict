<?php

// Auteur : Arnaud Da Silva
// Contact : dasilva.arnaud@gmail.com
// Pour Othentic.fr
// Mai 2013

	session_start();
	if (isset($_SESSION["erreur"]))
	{
		$erreur = $_SESSION["erreur"];
		unset ($_SESSION["erreur"]);
	}
	else
	{
		$erreur ="";
	}
	if (file_exists("./install/index.php"))
	{
		header("Location: ./install/index.php");
	}
	else
	{
		if (is_dir("./install"))
		{
			rmdir("./install");
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>DanaPict</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/gestion.css" type="text/css" media="all" />
</head>


<body>
	<div id="content">
	<form method="POST" name="FormulaireLogin" id="LoginForm" action="class/log.php">
		<p><img src="logo.png"></p>
		<p>Gestionnaire photo du site Othentic.fr</p>
		<?php echo "<p style='color:red;'>".$erreur."</p>"; ?>
		<p><label for "nomutilisateur">Nom utilisateur :</label>
		<input type = "text" name = "nomutilisateur" /><br></p>
		<p><label for "motdepasse">Mot de passe :</label>
		<input type = "password" name = "pwd" /><br></p>
		<input type="submit" value="Connexion" />
	</form>
	</div>
</body>
</html>
