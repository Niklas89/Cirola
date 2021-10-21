<?php
session_start();

if(!empty($_SESSION['users']))
{
	header('Location: index.php');
}

if(!empty($_POST))
{
	extract($_POST);
	$valid = true;
	
	if(empty($email))
	{
		$valid = false;
		$erreuremail = 'Indiquez votre email';
	}
	if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)===FALSE)
	{
		$valid = false;
		$erreuremail = 'Email invalide';
	}
	try{
	$bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
	$bdd->exec('SET NAMES utf8');
	}

	catch(Exeption $e){
	die('Erreur:'.$e->getMessage());
	}
	
	$req = $bdd->prepare('SELECT id,login FROM users WHERE  email=:email');
	$req->execute(array('email'=>$email));
	if(empty($erreuremail) && $req->rowCount()==0)
	{
		$valid =false;
		$erreurid = 'Cette adresse email ne correspond à aucun membre inscrit';
	}
	else 
	{
		$data = $req->fetch();
	}
	$req->closeCursor();
	
	if($valid)
	{
		$pass = rand(1000,5000);
		
		$to = $email;
		$subject = 'Oublie identifiants';
		$message = 'Voici votre nouveau login et votre nouveau mot de passe. Il est recommande de le changer. <br />
		Login : '.$data['login'].'<br />
		Mot de passe : '.$pass.'<br />
		Vous pouvez vous <a href="http://cirola.com/index.php"> connecter </a>dès maintenant sur SportBook';
		
		
		$headers = 'From:noreply@monsite.com'."\r\n";
		$headers.='MIME-version: 1.0'."\r\n";
		$headers.='Content-type: text/html; charset=utf-8'."\r\n";
		mail($to,$subject,$message,$headers);
		
		$req = $bdd->prepare('UPDATE users SET pass=:pass WHERE email=:email');
		$req->execute(array('pass'=>sha1($pass),
							'email'=>$email
							));
		$req->closeCursor();
		$ok = 'Un email vous a été envoyé avec vos identifiants';
	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="author" content="Niklas" />
	<meta name="contact" content="" />

	<title> Mot de passe oublié | Cirola.com </title>
	
		<link rel="stylesheet" type="text/css" href="templates/css/style.css" />
	</head>
	
	<body>
	
	<div id="conteneur">
		
		<?php include "templates/logo.html" ; ?>
		
		<div id="header"> <!-- Header -->
		
		</div> <!-- End header -->
		
		<div id="conteneur_body">
		<?php if(isset($erreurid)) echo '<div class="erreurid">'.$erreurid.'</div>';?>
					<?php if(isset($ok)) echo '<div class="ok">'.$ok.'</div>';?>
			<div id="formulaire">
				<h3>Veuillez saisir votre adresse mail ci-dessous : </h3>
				
				
			<form action='oublie.php' method='post'>
				
				<div>
				<label for="email">Votre adresse email</label>
				</div>
				<div>
				<input type="text" name="email" value="<?php if(isset($email)) echo $email;?>"/>
				<div class="error"><?php if(isset($erreuremail)) echo $erreuremail;?></div>
				</div>
				
				<input type="submit" class="" value="Renvoi" />
			
			</form>
			
			</div>	
			
			<div class="clear_fix"></div>
			
			
			<div id="footer">
				<?php include "templates/footer.php" ; ?>
			</div>
		</div>
	</div>

</body>

</html>