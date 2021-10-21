<?php

if(!empty($_POST))
{
  extract($_POST);
  $validation = true;
  
  try{ //Connection à la base de donnée
  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES utf8');
  }
  
  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  }
  
  
  $req = $bdd->prepare('SELECT id FROM users WHERE login=:nom');
  $req->execute(array('nom'=>$nom));
  if($req->rowCount()>0)
  {
    $validation = false;
    $erreurid = 'Ce pseudo est déjà pris';
  }
  
  $req = $bdd->prepare('SELECT id FROM users WHERE email=:email');
  $req->execute(array('email'=>$email));
  if($req->rowCount()>0)
  {
    $validation = false;
    $erreurid = 'Cette adresse e-mail est déjà utilisée par un membre';
  }
  $req->closeCursor(); //Ne pas oublier de fermer la requete une fois que c'est fini
  
  if($validation)
  {
    $hash = md5(rand(0,1000)); //genere le hash pour le lien d'activation
    
    $to = $email;
    $subject = 'Inscription|Validation';
    $message = 'Merci pour votre inscription sur SportBook!<br />
    Vous pourrez vous connecter sur le site après avoir cliqué sur le lien d\'activation ci-dessous.<br />
    Voici vos identifiants, nous vous recommandons de changer le mot de passe.<br />
    Login : '.$nom.'<br />
    Mot de passe : '.$pass.'<br />
    Cliquez sur le lien suivant pour activer votre compte<br />
    <a href="http://cirola.com/kevin/dev/verif.php?email='.$email.'&hash='.$hash.'">http://cirola.com/kevin/devSession/verif.php?email='.$email.'&hash='.$hash.'</a>';
    
    $headers = 'From:noreply@monsite.com'."\r\n";
    $headers.='MIME-version: 1.0'."\r\n";
    $headers.='Content-type: text/html; charset=utf-8'."\r\n";
    mail($to,$subject,$message,$headers); 
    
    $req = $bdd->prepare('INSERT INTO users (login,pass,email,lname,fname,city,postal,tel, hash) VALUES (:nom,:pass,:email,:lname,:fname,:city,:postal,:tel, :hash)');
    $req->execute(array(
	  'nom'=>$nom,	
      'pass'=>sha1($pass),
      'email'=>$email,
	  'lname'=>$lname,
	  'fname'=>$fname,
	  'city'=>$city,
	  'postal'=>$postal,
	  'tel'=>$tel,
	  'hash'=>$hash
    ));
    
    $req->closeCursor();
    $ok = 'Inscription réussie, vous allez recevoir un e-mail';
	unset($nom);
    unset($email);
	unset($lname);
	unset($fname);
	unset($city);
	unset($tel);
	unset($postal);
  }
}

?>