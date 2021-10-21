<?php


if(!empty($_POST))
{
  $valid = true;
  extract($_POST);
  
  if($valid)
  {
  try{
  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES utf8');
  }
  
  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  }
  
  $req = $bdd->prepare('SELECT * FROM users WHERE login=:login AND pass=:pass');
  $req->execute(array(
    'login'=>$login,
    'pass'=>sha1($pass)
  ));
  $data = $req->fetch();
  if($req->rowCount()==0)
  {
    $valid = false;
    $erreurid = 'Mauvais identifiants';
  }
  
  if($req->rowCount()>0 && $data['actif']==0)
  {
    $valid = false;
    $erreurid = 'Votre compte n\'est pas actif, consultez le mail envoyé pour l\'activer.';
  }
  if($req->rowCount()>0 && $data['actif']==2) 
  {
	$valid = false;
	$erreurde = 'Votre compte est désactivé';
  }
  else
  {
    if($req->rowCount()>0 && $data['actif']==1 )
    {
      $_SESSION['users'] = $login;
	    $_SESSION['id'] = $data['id'];
    }
	
	if($req->rowCount()>0 && $data['actif']==5 )
    {
      $_SESSION['users'] = $login;
	    $_SESSION['connexion']='OK';
    }
  }
    
    $req->closeCursor();

	if($valid && $data['actif']==1 )
    {
      header('Location: index.php');
    }
	
	if($valid && $data['actif']==5 )
    {
      header('Location: admin.php');
    }
  
  
  }
 }

?>
 
