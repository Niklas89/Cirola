
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

 $req = $bdd->prepare('SELECT * FROM users WHERE login=:login');
 $req->execute(array('login'=>$_SESSION['users']));
 $data = $req->fetch();
 $req->closeCursor();
  
 if(!empty($_POST))
 {
	extract($_POST);
	$valid2 = true;
	
	if($valid2)
	{
		$req = $bdd->prepare('UPDATE users SET pass=:pass WHERE login=:nom');
		$req->execute(array(
			'pass'=>sha1($pass),
			'nom'=>$nom
		));
		$req->closeCursor();
		$ok = 'Modification réussie.';
	
		header('Location: ../profil.php');
	}
 }
 
?>