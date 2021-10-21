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
		$req = $bdd->prepare('UPDATE message_home SET message=:message WHERE id=1');
		$req->execute(array(
			'message'=>$message
		));
		$req->closeCursor();
		$ok = 'Modification r�ussie.';
		
		header('Location: ../admin.php');
		
	}
 }

?>