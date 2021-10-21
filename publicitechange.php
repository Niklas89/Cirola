<?php

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
		$dossier = 'publicite/';
		$fichier = basename($_FILES['img']['name']);
		$taille_maxi = 50000000;
		$taille = filesize($_FILES['img']['tmp_name']);
		$extensions = array('.png', '.gif', '.jpg', '.jpeg');
		$extension = strrchr($_FILES['img']['name'], '.'); 
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
			 
			 move_uploaded_file($_FILES['img']['tmp_name'], $dossier . $fichier);
			 
			 $req = $bdd->prepare('UPDATE publicite SET img=:img, lien=:lien WHERE id=1');
			 $req->execute(array(
				'img'=>$fichier,
				'lien'=>$lien
				
			));
			$req->closeCursor();
			$ok = 'Modification r�ussie.';
		
			header('Location: admin.php');
		}
		else //Sinon (la fonction renvoie FALSE).
		{
          echo 'Echec de l\'upload !';
		}
	}
}

?>