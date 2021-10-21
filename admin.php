<?php
session_start();

if($_SESSION['connexion']=='OK'){
	}

	else {
		header('Location: index.php');
	}
	
try{
  $bdd = new PDO('mysql:host=mysql51-66.perso;dbname=critiquemanga', 'critiquemanga', 'critique78') or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES utf8');
  }
  
  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  }
  

if(isset($_POST['mailUtilisateur'])){
	if(!empty($_POST)){
	  extract($_POST);
	  $valid = true;
		
		if($valid){
		$to = $email;
		$subject = $sujet;
		$message = $corpsmessage;
		
		$headers = 'From:noreply@cirola.com'."\r\n";
		$headers.='MIME-version: 1.0'."\r\n";
		$headers.='Content-type: text/html; charset=utf-8'."\r\n";
		mail($to,$subject,$message,$headers);

		$ok = 'Email envoyé.';
		}
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="author" content="Niklas" />
	<meta name="contact" content="" />

	<title> Administration | Cirola.com </title>
	
	<link rel="stylesheet" type="text/css" href="templates/css/style.css" />
	
	<!-- DATE PICKER -->
		
		<link rel="stylesheet" href="templates/css/datepicker/jquery.ui.all.css">
		
		<script src="js/jquery-1.7.1.js"></script>
		<script src="js/jquery.ui.core.js"></script>
		<script src="js/jquery.ui.widget.js"></script>
		<script src="js/jquery.ui.tabs.js"></script>
		<script src="js/jquery.ui.datepicker.js"></script>
			
		<script>
			$(function() {
				$( "#qdate" ).datepicker();
				$( "#qdate2" ).datepicker();
				
			});
		</script>
		
	<!-- END DATE PICKER -->
	
	<!-- Popup  -->
		
		<script type="text/javascript">
			$(document).ready(function(){
										   
				//When you click on a link with class of poplight and the href starts with a # 
				$('a.poplight[href^=#]').click(function() {
					var popID = $(this).attr('rel'); //Get Popup Name
					var popURL = $(this).attr('href'); //Get Popup href to define size
						
				//Pull Query & Variables from href URL
					var query= popURL.split('?');
					var dim= query[1].split('&');
					var popWidth = dim[0].split('=')[1]; //Gets the first query string value

				//Fade in the Popup and add close button
		$('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('<a href="#" class="close"><img src="templates/images/close.png" class="btn_close" title="Close Window" alt="Close" /></a>');
				
				//Define margin for center alignment (vertical + horizontal) - we add 80 to the height/width to accomodate for the padding + border width defined in the css
				var popMargTop = ($('#' + popID).height() + 80) / 2;
				var popMargLeft = ($('#' + popID).width() + 80) / 2;
				
				//Apply Margin to Popup
				$('#' + popID).css({ 
					'margin-top' : -popMargTop,
					'margin-left' : -popMargLeft
				});
				
				//Fade in Background
				$('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
				$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer 
				
				return false;
			});
	
			
			//Close Popups and Fade Layer
			$('a.close, #fade').live('click', function() { //When clicking on the close or fade layer...
					$('#fade , .popup_block').fadeOut(function() {
						$('#fade, a.close').remove();  
				}); //fade them both out
					
					return false;
				});
				
			
			});

		</script>
		
		
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
						pass: {
							required: true,
							minlength: 5
						},
						confirm_password: {
							required: true,
							minlength: 5,
							equalTo: "#pass"
						}
					},
					messages: {
						pass: {
							required: "Entrez un mot de passe s'il vous plaît",
							minlength: "Votre mot de passe doit avoir au moins 5 caractères"
						},
						confirm_password: {
							required: "Entrez un mot de passe s'il vous plaît",
							minlength: "Votre mot de passe doit comporter au moins 5 caractères",
							equalTo: "Entrez le même mot de passe s'il vous plaît"
						}
					}
				});
			});
			</script>
			<script type="text/javascript">

			$(document).ready(function(){
			/* SUB MENU */
				
				$('#changeprofilhover').hide();
				var submenu = Boolean(false);
				
				$('.avatarimg').mouseenter(function(){
					if(submenu !== true){
						submenu = true;
						$('#changeprofilhover').fadeIn('200');
					}
				});
				
				$('#avatarimg').mouseleave(function(event){
					if(event.relatedTarget.id !== 'changeprofilhover'){
						$('#changeprofilhover').fadeOut('200');
						submenu = false;
					}	
				});	
				
				
				$('#changeprofilhover').mouseleave(function(event){
					if(event.relatedTarget.id !== 'avatarimg'){
						$('#changeprofilhover').fadeOut('200');
						submenu = false;	
					}
				});
			});
			</script>
			
				<script type="text/javascript">
				$(function() {
					$( "#tabs" ).tabs();
				});
			</script>
</head>

<body>

	<div id="conteneur">
	
		<?php include "templates/logo.html" ; ?>
	
		<div id="header"> <!-- Header -->
	
			<div id="login"> <!-- Login -->
				 
						<h2><span class="orange"> <?php echo $_SESSION['users'];?> </span></h2>
						<p> <a href="logout.php"> Déconnection </a> </p>
		
			</div> <!-- End login -->
		
		</div> <!-- End header -->
	
		<div id="conteneur_body"> <!-- Conteneur Body -->
				<div id="navigation">
					<ul>
						<li> <a class="border_clear" href="index.php" title="Accueil de Cirola"> Accueil </a> </li>
					</ul>
					<div class="clear"></div>
				</div>
				
				<div id="conteneur_tabs"/>
					<?php if(isset($ok)) echo '<div class="ok">'.$ok.'</div>';?>
					<div id="tabs">
						<ul>
							<li><a href="#tabs-1">Edition de la page d'accueil</a></li>
							<li><a href="#tabs-2">Bannir un utilisateur</a></li>
							<li><a href="#tabs-3">Ajouter un sport</a></li>
							<li><a href="#tabs-4">Espace publicitaire</a></li>
							<li><a href="#tabs-5">Envoyer un mail</a></li>
						</ul>
						<div id="tabs-1">
							
									<form method="POST" action="function/changemessage.php">
									
										 <label for="message">Modifier votre texte de bienvenue :</label> <textarea rows="4" name="message"></textarea>
										 <input type="submit" name="envoyer" value="Modifier"/>
										 
									</form>
									
						</div>
						
						<div id="tabs-2">
								<form method="POST" action="function/bannirutilisateur.php">
										
										<label for="login"> Choisissez l'utilisateur à bannir:</label> 
										 <select name="login">		
											<?php
											 try{
											  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
											  $bdd->exec('SET NAMES utf8');
												$reponse = $bdd->query('SELECT * FROM users');
												while ($data = $reponse->fetch()){ ?>
													<option value="<?php echo $data['login']; ?>"><?php echo $data['login']; ?></option>
													 <?php
												}
												$reponse->closeCursor();
											}
												catch(Exeption $e){
												die('Erreur:'.$e->getMessage()); } ?>
										  </select>
										 <input type="submit" name="envoyer" value="Bannir"/>
										 
								</form>
						</div>
						
						<div id="tabs-3">
							<form method="POST" action="function/ajoutersport.php">
									
										 <label for="sport">Ajouter un sport:</label> <input type="text" name="sport"/>
										 <input type="submit" name="envoyer" value="Ajouter"/>
										 
							</form>
						</div>
					
						
						<div id="tabs-4">
						
									<form method="POST" action="publicitechange.php" enctype="multipart/form-data">
									
										 <label for="img">Ajouter l'img de votre publicité:</label> <input type="file" name="img"/>

										<label for="lien">Lien de la publicité:</label> <input type="text" name="lien"/>
										 
										 <input type="submit" name="envoyer" value="Changer la publicité"/>
										 
									</form>
						</div>
						
						<div id="tabs-5">
							<form method="POST" action="admin.php">
										
										<label class="gris" for="email"> Choisir la personne à qui envoyer un mail : </label> 
										 <select name="email">		
											<?php
											 try{
											  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
											  $bdd->exec('SET NAMES utf8');
												$reponse = $bdd->query('SELECT * FROM users');
												while ($data = $reponse->fetch()){ ?>
													<option value="<?php echo $data['email']; ?>"><?php echo $data['email']; ?></option>
													 <?php
												}
												$reponse->closeCursor();
											}
												catch(Exeption $e){
												die('Erreur:'.$e->getMessage()); } ?>
										  </select>
										  
										  <div>
										  <label class="gris" for="sujet"> Le Sujet du message : </label>
										  <input type="text" name="sujet"/>
										  </div>
										  
										  <div>
										  <label class="gris" for="corpsmessage"> Le corps du message : </label>
										  <textarea cols="30" rows="10"name="corpsmessage"> </textarea>
										  </div>
										  
										 <input type="submit" name="mailUtilisateur" value="Envoyer"/>
										 
							</form>
					
						</div>
					</div>
				</div>

				
				
			<div class="clear"></div>
			
			<div id="footer">
				<?php include "templates/footer.php" ; ?>
			</div>
			
		</div>
	</div>
		
	
	


</body>

</html>