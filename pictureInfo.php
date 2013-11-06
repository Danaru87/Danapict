<?php
// Auteur : Arnaud Da Silva
// Contact : dasilva.arnaud@gmail.com
// Pour Othentic.fr
// Mai 2013
	require_once ('./class/data.class.php');
	require_once ('./class/picture.class.php');
	require_once ('./class/bdd.fn.php');
	
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
	$data = new Data();
	$db = Connect();
	
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
		$titre = '"'.$picture->GetTitre().'"';
		$description = '"'.$picture->GetDescription().'"';
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
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/gestion.css">
	<script src="../lightbox/js/jquery-1.7.2.min.js"></script>
	<script src="../lightbox/js/lightbox.js"></script>
	<link href="../lightbox/css/lightbox.css" rel="stylesheet" />
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
		<div id='image'>
			<a href="<?php echo $url; ?>" rel="lightbox" title=<?php echo $description;?> >
			<?php echo $img; ?>
			</a>
		</div>
		<div id='formulaire'>
			<div id='form'>
				<form method="POST" name="ModifPicture" action="./class/modifier.picture.php" onsubmit="return confirm('Etes vous sur de votre choix ?');"> 
					<label>Url: </label><input class="readonly" type='text' name='url' value=<?php echo $url; ?> readonly required></input><br>
					<label>Mini: </label><input class="readonly" type='text' name='urlMini' value=<?php echo $urlMini; ?> readonly required></input><br>
					<label>ID Image: </label><input class="readonly" type="text" name ='id' value=<?php echo $id; ?> readonly required></input><br>
					<label>Titre: </label><input class="input" type="text" name='titre' placeholder=<?php echo $titre; ?>></input><br>
					<label>Visible: </label><input type="checkbox" name="visible" value="1" 
												<?php if($visible ==1)
												{
													echo 'checked';
												} ?>></input><br>
					<label>Description: </label><br>
					<textarea class="input" cols='45' rows ='6' name="description" placeholder=<?php echo $description; ?>></textarea><br>
					<input type="submit" value="Modifier" name="valider"></input>
					<input type="submit" value="Supprimer" name="supprimer"></input>
				</form>
			</div>
			<div class="spacer"></div>
		</div>
	</div>
</div>
</body>
</html>