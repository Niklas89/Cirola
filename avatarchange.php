<?php

session_start();
$nom = $_SESSION['users'];

if(empty($_SESSION['users']))
{
	header('Location: ../index.php');
}

try{
  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES utf8');
  }
  
  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  }
 
 if(!empty($_POST))
 {
	extract($_POST);
	$valid3 = true;
	
	if($valid3)
	{
		$dossier = 'avatar/';
		$fichier = basename($_FILES['avatar']['name']);
		$taille_maxi = 100000;
		$taille = filesize($_FILES['avatar']['tmp_name']);
		$extensions = array('.png', '.gif', '.jpg', '.jpeg');
		$extension = strrchr($_FILES['avatar']['name'], '.'); 
		//D�but des v�rifications de s�curit�...
		if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
		{
			 $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
		}
		if($taille>$taille_maxi)
		{
			 $erreur = 'Le fichier est trop gros...';
		}
		if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
		{
			 //On formate le nom du fichier ici...
			 $fichier = strtr($fichier, 
				  '����������������������������������������������������', 
				  'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
			 $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
			 
			 move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier);
			 
			 $req = $bdd->prepare('UPDATE users SET avatar=:avatar WHERE login=:nom');
			 $req->execute(array(
				'avatar'=>$fichier,
				'nom'=>$nom
			));
			$req->closeCursor();
			$ok = 'Modification r�ussie.';
		
			header('Location: profil.php');
		}
		else //Sinon (la fonction renvoie FALSE).
		{
          echo 'Echec de l\'upload !';
		}
	}
}

?>