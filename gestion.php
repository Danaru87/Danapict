<?php
// Auteur : Arnaud Da Silva
// Contact : dasilva.arnaud@gmail.com
// Pour Othentic.fr
// Mai 2013
	require_once ('./class/data.class.php');
	require_once ('./class/picture.class.php');
	$data = new Data();
	
	session_start();
	if (!isset($_SESSION["user"]))
	{
  		header("Location: index.php");
	}
	else if ($_SESSION["user"] == null)
	{
  		header("Location:index.php");
  		exit;
	}
	else
	{
		$user = $_SESSION['user'];
	}
	
	if (isset($_GET['visible']))
	{
		if ($_GET['visible'] == 1)
		{
			$visiblevar = '&visible=1';
			$tabPicture = $data->VisiblePicture();
		}
		elseif ($_GET['visible'] == 0)
		{
			$visiblevar = '&visible=0';
			$tabPicture = $data->NoVisiblePicture();
		}
		elseif ($_GET['visible'] == 2)
		{
			$visiblevar = '&visible=2';
			$tabPicture = $data->AllPicture();
		}
	}
	else
	{
		$visiblevar = null;
		$tabPicture = $data->AllPicture();
	}
	

	if (isset($_GET['id']))
	{
		$id = $_GET['id'];
		$picture = $data->InfosPicture($id);
		$titre = $picture->GetTitre();
		$description = $picture->GetDescription();
		$url = $picture->GetURL();
		$img = "<img src=".$url." width='200' height='200' alt='No Image'/>";
		$urlMini = $picture->GetURLMini();
		$visible = $picture->GetVisible();

	}
	else
	{
		$id = "selectioner image";
		$titre = "selectioner image";
		$description = "selectioner image";
		$url = "selectioner image";
		$urlMini = "selectioner image";
		$visible = "selectioner image";
		$img = null;
	}
?>

<!DOCTYPE HTML>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/gestion.css">
</head>
<body>
<div id='content'>
	<div id="logo">
		<img src="logo.png" />
	</div>
	<div id="menu">
		<ul>
			<li><a href="./gestion.php">Accueil </a></li>
			<li><a href="./upload.php">Ajouter Image</a></li>
		</ul>
	</div>
	<div class="spacer"></div>
	<div id='miniature'>
		<div id="visible">
			<ul>
				<li><a href="?visible=1">Visibles</a></li>
				<li><a href="?visible=0">Invisibles</a></li>
				<li><a href="?visible=2">Toutes</a></li>
			</ul>
		</div>
		<div id="roll">
		<?php
			foreach ($tabPicture as $pid => $ppicture) 
			{
				echo "<a href='./pictureInfo.php?id=".$ppicture->GetID().$visiblevar."'><img src='./".$ppicture->GetURLMini()."' /></a>";
			}
		?>
		<form method="POST" name="Delete" action="class/modifier.picture.php" onsubmit="return confirm('Etes vous sur de votre choix ?');"><INPUT type="submit" value="Supprimer Tout" name="alldell" /></form>
		</div>
		<div class="spacer"></div>
	</div>
	<div id='accueil'>
		<p>Bienvenu dans le systeme de gestions d'images</p>
		<p>Ajoutez une image ou selectionnez une image miniature ci-dessus pour acc&eacuteder a ses informations et les modifier.</p>
	</div>
</div>
</body>
</html>