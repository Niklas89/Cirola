
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
	$valid3 = true;
	
	if($valid3)
	{
		$req = $bdd->prepare('UPDATE users SET lname=:lname, fname=:fname, city=:city, postal=:postal, tel=:tel WHERE login=:nom');
		$req->execute(array(
			'lname'=>$lname,
			'fname'=>$fname,
			'city'=>$city,
			'postal'=>$postal,
			'tel'=>$tel,
			'nom'=>$nom
		));
		$req->closeCursor();
		
	
		header('Location: ../profil.php');
		$ok = 'Modification r�ussie.';
	}
 }
 
?>
