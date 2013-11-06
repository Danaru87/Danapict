<?php

// Auteur : Arnaud Da Silva
// Contact : dasilva.arnaud@gmail.com
// Mai 2013

require_once ('picture.class.php');
require_once ('data.class.php');
require_once ('bdd.fn.php');
$data = new Data();
$picture = new Picture();
$db = Connect();

if (isset($_POST['visible'])) // Verification que la checkbox 'visible' est cochée
{
	$visible = 1;
}
else // ou non cochée
{
	$visible = 0;
}
if (isset($_POST['valider'])) // Validation des modifications des Infos de l'image
{
	$id = $_POST['id'];
	$picture = $data->InfosPicture($id);  // On recup les infos de l'image dans la base (Sans Modifs)
	if ($_POST['titre'] != '') // Si champs modifié (cliqué puis rempli)
	{	
		$titre = $db->real_escape_string($_POST['titre']);
		$picture->SetTitre($titre); // On set les modifications à l'objet Picture (Ce qui effectue en direct une modif dans la BDD)
	}
	if ($_POST['description'] !='') // Même que ci dessus
	{
		$description = $db->real_escape_string($_POST['description']);
		$picture->SetDescription($description);
	}
	$picture->SetVisible($visible);
	header('location: ../pictureInfo.php?id='.$id);
}
if (isset($_POST['supprimer'])) // Suppression de l'image (BDD + Fichier)
{
	$id = $_POST['id'];
	$picture = $data->InfosPicture($id); // On recup les infos de l'image dans la base (Sans Modifs)
	$data->DelPicture($picture);
	header('location: ../gestion.php');
}

if (isset($_POST['alldell'])) // Si clic sur le bouton tout supprimer
{
	$data->DelAllPicture(); // On supprime l'ensemble des images présentes sur le serveur et la BDD
	header('location:../gestion.php');
}

?>