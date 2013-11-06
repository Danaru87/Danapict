<?php
// Auteur : Arnaud Da Silva
// Contact : dasilva.arnaud@gmail.com
// Pour Othentic.fr
// Mai 2013
	require_once('./class/picture.class.php');
	require_once('./class/data.class.php');
	require_once('./class/bdd.fn.php');
	
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
	
	$db = Connect();

	//Vérifications que les infos sont bien passées depuis le formulaire
	if (!isset($_POST['titre']))
		die ("Erreur, pas de variable transmise");
	if (!isset($_FILES['picture']))
		die ("aucune image transmise");

	$dir = "./image/"; // Dossier dans lequel sont stockés les images

	// Récupération des informations du formulaire
	$titre = $_POST['titre'];
	$description = $_POST['description'];
	if (isset($_POST['visible']))
	{
		$visible = 1;
	}
	else
	{
		$visible = 0;
	}

	//Récupération des infos du fichier
	$type = $_FILES['picture']['type'];
	$ext = strtolower( substr( strrchr($_FILES['picture']['name'], '.'), 1)); // On récupère l'extension depuis le nom entier du fichier
	$tmppath = $_FILES['picture']['tmp_name'];

	//création d'un nom unique
	// pour eviter les conflits de fichiers dans le dossier
	// Pour image brut
	$nom = uniqid().'.'.$ext;
	$url = $dir.$nom;
	// Pour miniature
	$nomMini = uniqid().'.'.$ext;
	$urlMini = $dir."thumb/".$nomMini;


	// Création d'une miniature
	if ($ext == jpg)
	{
		$source = imagecreatefromjpeg($tmppath);
		$destination = imagecreatetruecolor(75, 75);

		$largeur_source = imagesx($source);
		$hauteur_source = imagesy($source);
		$largeur_destination = imagesx($destination);
		$hauteur_destination = imagesy($destination);

		imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

		imagejpeg($destination, $urlMini);
	}
	elseif ($ext == png) 
	{
		$source = imagecreatefrompng($tmppath);
		$destination = imagecreatetruecolor(75, 75);

		$largeur_source = imagesx($source);
		$hauteur_source = imagesy($source);
		$largeur_destination = imagesx($destination);
		$hauteur_destination = imagesy($destination);

		imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

		imagepng($destination, $urlMini);
	}
	// Fin création de miniature


	// On echappe les caractères spéciaux
	$titre = $db->real_escape_string($titre);
	$description = $db->real_escape_string ($description);
	$url = $db->real_escape_string($url);
	//$urlMini = $db->real_escape_string ($urlMini);

	// création d'un objet Picture regroupant toutes les infos
	$picture = new Picture(null, $titre, $description, $url, $urlMini, $visible);

	// On effectue la requète sur la BDD
	$Data = new DATA();
	$value = $Data->AddPicture($tmppath, $picture);
	// On recup la valeur du test de AddPicture
	// Afin d'afficher un message d'erreur ou de confirmation
	// sur la page d'upload d'image
	header('location: ./upload.php?value='.$value);
?>