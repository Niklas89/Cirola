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
	$valid = true;
	
	if($valid)
	{
		$req = $bdd->prepare('UPDATE users SET actif=4 WHERE login=:login');
		$req->execute(array(
			'login'=>$login,
		));
		$req->closeCursor();
		$ok = 'Modification r�ussie.';
		
		header('Location: ../admin.php');
		
	}
 }

?>