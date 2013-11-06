<?php

// Auteur : Arnaud Da Silva
// Contact : dasilva.arnaud@gmail.com
// Mai 2013

	require_once ('picture.class.php');
	require_once('bdd.fn.php');
	require_once ('user.class.php');
	Class Data
	{

		public function __construct() // Constructeur de la classe, on initiale uniquement la connection a la BDD
		{
		}

		// Traitement des données d'une image dans la BDD

		// Recuperer les infos d'une image
		public function InfosPicture($id)
		{
			$db = Connect() or die("Erreur dans la connexion a la BDD");
			mysqli_set_charset ($db, 'utf8');
			$request = "SELECT * FROM pictures where id='".$id."';"; // On récupere les infos de l'image dont l'id est en parametre
			$result = $db->query($request) or die("Erreur dans la requete");
			if ($ligne = $result->fetch_array(MYSQLI_ASSOC))
			{
				$id = $ligne['id'];
				$titre = $ligne['titre'];
				$description = $ligne['description'];
				$url = $ligne['url'];
				$urlMini = $ligne['urlMini'];
				$visible = $ligne['visible'];
				$picture = new Picture($id, $titre, $description, $url, $urlMini, $visible);
				return $picture; // On retourne l'objet créé à partir de la BDD
			}
			else
			{
				return null;
			}
		}

		// ajouter une image dans la BDD
		public function AddPicture($tmppath, $picture)
		{
			$db = Connect() or die("Erreur dans la connexion a la BDD");
			mysqli_set_charset ($db, 'utf8');
			$deplacement = move_uploaded_file($tmppath, $picture->GetURL()) or die("Impossible de déplacer le fichier"); // On envoi l'image vers le serveur
			$request = "INSERT INTO pictures (titre, description, url, urlMini, visible) VALUES ('".$picture->GetTitre()."',
																		'".$picture->GetDescription()."',
																		'".$picture->GetURL()."','".$picture->GetURLMini()."','".$picture->GetVisible()."'
																	)";
			$result = $db->query($request) or die ("Erreur dans la requète SQL ADDPICTURE"); // on ajoute l'image dans la BDD
			// On test si la commande SQL/BDD est correct
			if ($result)
			{
				// Si oui, on retourne true
				return true;
			}
			else
			{
				// Sinon on retourne false
				return false;
			}

		}

		public function PremiereImageVisible() // On recupère la premiere image avec le statut Visible
		{
			$db = Connect();
			mysqli_set_charset($db, 'utf8');
			$request = "SELECT * FROM pictures WHERE id=(SELECT MAX(id) FROM pictures) AND visible=1";
			$result = $db->query($request) or die("Erreur dans la requete");
			if ($ligne = $result->fetch_array(MYSQLI_ASSOC))
			{
				$id = $ligne['id'];
				$titre = $ligne['titre'];
				$description = $ligne['description'];
				$url = $ligne['url'];
				$urlMini = $ligne['urlMini'];
				$visible = $ligne['visible'];
				$picture = new Picture($id, $titre, $description, $url, $urlMini, $visible);
				return $picture; // On retourne l'objet créé à partir de la BDD
			}
			else
			{
				return null;
			}
		}

		// Modifier une image dans la BDD
		public function ModifierPicture($picture)
		{
			$db = Connect() or die("Erreur dans la connexion a la BDD");
			mysqli_set_charset ($db, 'utf8');
			$titre = $picture->GetTitre();
			$description = $picture->GetDescription();
			$url = $picture->GetURL();
			$urlMini = $picture->GetURLMini();
			$visible = $picture->GetVisible();
			$request = "UPDATE pictures SET titre ='".$titre."', 
											description='".$description."', 
											url='".$url."', 
											urlMini='".$urlMini."', 
											visible='".$visible."' 
											WHERE id='".$picture->GetID()."'";
			$result = $db->query($request);
			// On test si la commande de modif est correct
			// On retourne le resultat pour un eventuel affichage
			if ($result)
			{
				return true;
			}
			else
			{
				return false;
			}

		}
		// Suppression de l'obet dans la BDD
		public function DelPicture($picture)
		{
			$db = Connect() or die("Erreur dans la connexion a la BDD");
			mysqli_set_charset ($db, 'utf8');
			$id = $picture->GetID();
			$url = $picture->GetURL();
			$urlMini = $picture->GetURLMini();
			$request = "DELETE FROM pictures WHERE id='".$id."'";
			$result = $db->query($request) or die ("Erreur dans la requète");
			//Si l'image est bien supprimé de la BDD
			if ($result)
			{
				unlink('../'.$url) or die ('fichier introuvable'); // on suprime l'image du dossier
				unlink('../'.$urlMini); // on suprime sa miniature
				return true;
			}
			// Sinon
			else
			{
				return false;
			}
		}

		//Suppression de toutes les images dans la BDD et sur le Serveur
		public function DelAllPicture()
		{
			$db = Connect();
			mysqli_set_charset($db,'utf8');
			$request = "TRUNCATE TABLE pictures";
			$result = $db->query($request) or die ("Erreur dans la requete de suppression");
			if ($result)
			{

				// On se charge du traitement des miniatures
				$dossier_miniature = "../image/thumb"; // Repertoire contenant les miniatures
				$repertoire = opendir($dossier_miniature); // On travail dans le répertoire précèdement précisé
				while (false !==($fichier=readdir($repertoire))) // Tant qu'il y a un fichier dans le dossier
				{
					$chemin = $dossier_miniature."/".$fichier; // Chemin du fichier à supprimer

					// Si le fichier n'est pas un répertoire
					if ($fichier !=".." AND $fichier !="." AND !is_dir($fichier))
					{
						unlink ($chemin); // On efface le fichier
					}
				}
				closedir($repertoire);

				// Maintenant on passe au traitement des images sources
				// Le principe est exactement le même seul le dossier change
				$dossier = "../image";
				$repertoire = opendir($dossier);
				while (false !==($fichier=readdir($repertoire)))
				{
					$chemin = $dossier."/".$fichier;
					if ($fichier !=".." AND $fichier !="." AND !is_dir($fichier) AND $fichier != 'thumb')
					{
						unlink($chemin);
					}
				}
				closedir($repertoire);
			return true;
			}
			else
			{
				return false;
			}

		}

		//recupérer toutes les images
		public function AllPicture ()
		{
			$db = Connect() or die ("Erreur dans la connexion a la BDD");
			mysqli_set_charset ($db, 'utf8');
			$request = 'SELECT * FROM pictures';
			$result = $db->query($request) or die ("erreur dans la requète");
			$tabPicture = array();
			while ($ligne = $result->fetch_array(MYSQLI_ASSOC))
			{
				//On crée un tableau qui va contenir les images detournées par la BDD
				$tabPicture [$ligne['id']] = new Picture ($ligne['id'], $ligne['titre'], $ligne['description'], $ligne['url'], $ligne['urlMini'], $ligne['visible']);
			}
			return $tabPicture;	// On retourne le tableau
		}

		public function VisiblePicture() // Retourne toutes les images dont le statut est visible
		{
			$db = Connect() or die ("Erreur dans la connexion a la BDD");
			mysqli_set_charset ($db, 'utf8');
			$request = 'SELECT * FROM pictures WHERE visible = 1';
			$result = $db->query($request) or die ("erreur dans la requète");
			$tabPicture = array();
			while ($ligne = $result->fetch_array(MYSQLI_ASSOC))
			{
				//On crée un tableau qui va contenir les images detournées par la BDD
				$tabPicture [$ligne['id']] = new Picture ($ligne['id'], $ligne['titre'], $ligne['description'], $ligne['url'], $ligne['urlMini'], $ligne['visible']);
			}
			return $tabPicture;	
		}
		
		public function NoVisiblePicture() // Retourne toutes les images dont le statut est Invisible
		{
			$db = Connect() or die ("Erreur dans la connexion a la BDD");
			mysqli_set_charset ($db, 'utf8');
			$request = 'SELECT * FROM pictures WHERE visible = 0';
			$result = $db->query($request) or die ("erreur dans la requète");
			$tabPicture = array();
			while ($ligne = $result->fetch_array(MYSQLI_ASSOC))
			{
				//On crée un tableau qui va contenir les images detournées par la BDD
				$tabPicture [$ligne['id']] = new Picture ($ligne['id'], $ligne['titre'], $ligne['description'], $ligne['url'], $ligne['urlMini'], $ligne['visible']);
			}
			return $tabPicture;	
		}

		public function Loggin($login, $mdp) // On verifie le couple Loggin/Pass de l'utilisateur
		{
			$db = Connect();
			$request = "SELECT * FROM user WHERE loggin ='".$login."' AND mdp='".$mdp."'";
			$result = $db->query($request) or die("Erreur de requete");
			if ($result) // Si il est bon
			{
				$user = new User($login, $mdp); // On crée un objet User, ce qui donne l'accès au gestionnaire
			}
			else // Sinon on retourne null, ce qui empèche l'accès au gestionnaire
			{
				$user = null;
			}
			return $user;
		}
	}
?>