<?php
session_start();
if(!empty($_GET) && !empty($_GET['hash']))
{
	extract($_GET);
}
else
{
	header('Location: index.php');
}

  try{
  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES utf8');
  }
  
  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  }
	
	$req = $bdd->prepare('SELECT email,hash,actif FROM users WHERE email=:email AND hash=:hash AND actif=:actif');
	$req->execute(array(
		'email'=>$email,
		'hash'=>$hash,
		'actif'=>0
	));
	$req->closeCursor();
	
	if($req->rowCount()==0)
	{
		$erreur = 'Invalide ! Si vous avez déjà cliqué sur le lien d\'activation, votre compte est déjà actif, sinon consultez votre
		boite de réception';
	}
	
	else
	{
		$req = $bdd->prepare('UPDATE users SET actif=1 WHERE email=:email AND hash=:hash AND actif=:actif');
		$req->execute(array(
		'email'=>$email,
		'hash'=>$hash,
		'actif'=>0
		));
		$req->closeCursor();
		
		$ok = 'Votre compte est actif ! Vous pouvez vous <a href="index.php">connecter</a> !';
	}
	
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="author" content="Niklas" />
	<meta name="contact" content="" />

	<title> Vérification | Cirola.com </title>
	
	<link rel="stylesheet" type="text/css" href="templates/css/style.css" />
	
	<!-- DATE PICKER -->
		
		<link rel="stylesheet" href="templates/css/datepicker/jquery.ui.all.css">
		
		<script src="js/jquery-1.7.1.js"></script>
		<script src="js/jquery.ui.core.js"></script>
		<script src="js/jquery.ui.widget.js"></script>
		<script src="js/jquery.ui.datepicker.js"></script>
			
		<script>
			$(function() {
				$( "#qdate" ).datepicker();
				$( "#qdate2" ).datepicker();
				
			});
		</script>
		
	<!-- END DATE PICKER -->
	
	<script src="lib/jquery.js" type="text/javascript"></script>
	<script src="lib/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript">
			$.validator.setDefaults({
				submitHandler: function() {  $(form).submit(); }
			});

			$().ready(function() {
				$("#commentForm").validate();

				// Validation quand on tab ou quand on envoie
				$("#signupForm").validate({
					rules: {
						nom: {
							required: true
						},
						lname: {
							required: true
						},
						fname: {
							required: true
						},
						pass: {
							required: true,
							minlength: 5
						},
						confirm_password: {
							required: true,
							minlength: 5,
							equalTo: "#pass"
						},
						email: {
							required: true,
							email: true
						},
						city: {
							required: true
						},
						postal: {
							required: true,
							number:true
						},
						tel: {
							required: true,
							number:true
						},
						
					},
					messages: {
						nom: {
							required: "Entrez un login s'il vous plaît",
						},
						lname: {
							required: "Entrez votre nom s'il vous plaît",
						},
						fname: {
							required: "Entrez votre prénom s'il vous plaît",
						},
						pass: {
							required: "Entrez un mot de passe s'il vous plaît",
							minlength: "Votre mot de passe doit avoir au moins 5 caractères"
						},
						confirm_password: {
							required: "Entrez un mot de passe s'il vous plaît",
							minlength: "Votre mot de passe doit comporter au moins 5 caractères",
							equalTo: "Entrez le même mot de passe s'il vous plaît"
						},
						city: {
							required: "Entrez votre ville s'il vous plaît"
						},
						postal: {
							required: "Entrez votre code postal s'il vous plaît",
							number: "Ceci n'est pas un code postal"
						},
						tel: {
							required: "Entrez votre numéro de téléphone s'il vous plaît",
							number:"Entrez vos 10 chiffres de votre numéro, merci"
							
						},
						email: "Entrez une adresse mail valide s'il vous plaît"
						
					}
				});
			});
			</script>
</head>

<body>

	<div id="conteneur">
		
		<?php include "templates/logo.html" ; ?>
		
		<div id="header"> <!-- Header -->
		
		</div> <!-- End header -->
		
		<div id="conteneur_body">
			
			<div id="inscription_formulaire">
				<h3>Confirmation</h3>
				
				<div class="ok">
					<?php if(isset($ok)) echo $ok;?>	
				</div>
				
				<div class="erreurid">
					<?php if(isset($erreur)) echo $erreur;?>
				</div>
				
				<a href="index.php" title="Retourner à l'accueil"> Accueil </a>
			</div>
			
			<div id="footer">
				<?php include "templates/footer.php" ; ?>
			</div>
		</div>
	</div>
</body>

</html>