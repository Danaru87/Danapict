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
  		header("Location: ./index.php");
	}
	else if ($_SESSION["user"] == null)
	{
  		header("Location: ./index.php");
  		exit;
	}
	else
	{
		$user = $_SESSION['user'];
	}
	
	if(isset($_GET['value']))
	{
		$message = 'Votre image a ete envoyee';
	}
	else
	{
		$message = null;
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

?>

<!DOCTYPE HTML>
<html>
<head>
	<META charset="UTF-8">
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
		<form method="POST" name="Delete" action="./class/modifier.picture.php" onsubmit="return confirm('Etes vous sur de votre choix ?');"><INPUT type="submit" value="Supprimer Tout" name="alldell" /></form>
		</div>
		<div class="spacer"></div>
	</div>
	<div id='content2'>
		<div id='upload'>
			<form method="POST" name="UploadPic" action="./upp.picture.php" enctype="multipart/form-data">
			<label><?php echo $message ?></label><br>
			<input type="file" accept="image/x-png image/jpeg" name="picture" id='picture' required /><br>
			<label>Titre:</label>
			<input type="text" name="titre" required /><br>
			<label>Description :</label><br>
			<textarea rows="10" cols="30" name="description"></textarea><br>
			<label> Image Visible ? </label>
			<input type='checkbox' name="visible" value="1" checked /><br>
			<input type="submit" value="Valider" />
			</form>
			</div>
			<div class="spacer"></div>
		</div>
	</div>
</div>
</body>
</html>