<?php 

	 if(!empty($_POST))
 {
	extract($_POST);
	$valid = true;
	
	if($valid)
	{
		$req = $bdd->prepare('UPDATE users SET email=:email WHERE login=:nom');
		$req->execute(array(
			'email'=>$email,
			'nom'=>$nom
		));
		$req->closeCursor();
		$ok = 'Modification réussie.';
		
		session_destroy();
	}
 }

?>