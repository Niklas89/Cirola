<?php

session_start();
$nom = $_SESSION['users'];

if(empty($_SESSION['users']))
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
  
 $req = $bdd->prepare('SELECT * FROM users WHERE login=:login');
 $req->execute(array('login'=>$_SESSION['users']));
 $data = $req->fetch();
 $dir = 'avatar/';
 $req->closeCursor();
 
include 'function/change_email.php';


include 'function/friends.fn.php';
$friend = new Friends();



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="author" content="Niklas" />
	<meta name="contact" content="" />

	<title> Profil | Cirola.com </title>
	
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
</head>

<body>

	<div id="conteneur">
	
		<?php include "templates/logo.html" ; ?>
	
		<div id="header"> <!-- Header -->
	
			<div id="login"> <!-- Login -->
				 
						<div id="logout">
						<h2><span class="orange"> <?php echo $_SESSION['users'];?> </span></h2>
						<p> <a href="logout.php"> Déconnection </a> </p>
						</div>
		
			</div> <!-- End login -->
		
		</div> <!-- End header -->
	
		<div id="conteneur_body"> <!-- Conteneur Body -->
			
				<div id="navigation"> <!-- Menu -->
				
					<?php include "templates/navigation.php" ; ?>
				
				</div> <!-- End Menu -->
				
				<div class="clear"></div>
				
				<div id="haut_profil"> <!-- Bloc Haut profil -->
				<?php if(isset($ok)) echo '<div class="ok">'.$ok.'</div>';?>
					
					<div id="changeprofilhover">
						<a href='#?w=500' rel='popup_avatar' class='poplight' title='Modifier son avatar'>
						<div class="profilhover">
						</div>
						</a>
						<p> Cliquer sur la photo pour changer votre avatar </p>
					</div>
					
					<div class="bloc01_profil"> <!-- Bloc 01 -->
					
						<?php
							 echo "<a href='#?w=500' rel='popup_avatar' class='poplight' title='Modifier son avatar'><img class='avatarimg' src='".$dir.$data['avatar']."'/></a>";
						?>
						
						
						<!-- POP UP MODIFICATION avatar -->
							<div id="popup_avatar" class="popup_block">
								<h2> Modifier son avatar Cirola: </h2>
								<div class="identifiant_profil">
								
									<h3>Changement de l'avatar: </a>
									
									<form method="POST" action="avatarchange.php" enctype="multipart/form-data">
									
										 <label for="avatar">Ajouter votre :</label> <input type="file" name="avatar">
										 <input type="submit" name="envoyer" value="Envoyer le fichier"/>
										 
									</form>
								</div>
							</div> 
						
						<p> 
							<?php
								  echo $data['lname'];
								  echo ' ';
								  echo $data['fname'];
								   echo ' - ';
								  echo $data['login'];
							?> 
						</p>
					
						<div>
							<a href="#?w=500" rel="popup_modification" class="poplight" title="Modifier son profil"><img src="templates/images/changer_profil.png" class="modifierprofil" alt="Modifier son profil" /></a>
						</div>
					
						<!-- POP UP MODIFICATION PROFIL -->
							<div id="popup_modification" class="popup_block">
								
								<h2> Modifier son profil Cirola: </h2>
								<div class="identifiant_profil">
								
									<h3>Changements des identifiants : </a>
									
									<form action="profil.php" method="post">
									
									<div>
									<label for="email">Votre E-mail :</label> <!-- Email -->
									<input type="text" name="email" value="<?php echo $data['email'];?>" onfocus="this.value='';" onblur="if(this.value==''){this.value='<?php echo $data['email'];?>';}"/>
									</div>
									
									<input type="submit" class="submit_button" value="Modifier" />
				
									</form>
								</div>
								
								<div class="identifiant_profil">
									<h3>Changement de votre mot de passe : </h3>
									
									<form id="signupForm" action="function/change_mdp.php" method="post">
									
									<div>
									<label for="pass">Mot de passe</label> <!-- Password -->
									<input id="pass" name="pass" type="password" />
								    </div>
									
									<div>
									<label for="confirm_password">Confirmer votre mot de passe</label> <!-- Confirm Password -->
									<input id="confirm_password" name="confirm_password" type="password"/>
									</div>
									
									<input type="submit" class="submit_button" value="Modifier" />
				
									</form>
									
									
								</div>
								
								<div class="identifiant_profil">
								
									<h3>Changement de vos coordonnées personnelles : </h3>
										<form class="signupForm" action="function/change_personnelle.php" method="post">
									
										  <div>
										  <label for="lname"> Nom :</label> <!-- Nom  -->
										  <input type="text" name="lname"value="<?php echo $data['lname'];?>" onfocus="this.value='';" onblur="if(this.value==''){this.value='<?php echo $data['lname'];?>';}" />
										  </div>
										 
										  <div>
										  <label for="fname">Prénom :</label> <!-- Prenom  -->
										  <input type="text" name="fname"value="<?php echo $data['fname'];?>" onfocus="this.value='';" onblur="if(this.value==''){this.value='<?php echo $data['fname'];?>';}" />
										  </div>
										  
										  <div>
										  <label for="city">Ville :</label> <!-- Ville  -->
										  <input type="text" name="city" value="<?php echo $data['city'];?>" onfocus="this.value='';" onblur="if(this.value==''){this.value='<?php echo $data['city'];?>';}"/>
										  </div>
										  
										  <div>
										  <label for="postal">Code Postal :</label> <!-- Postal  -->
										  <input type="text" name="postal" value="<?php echo $data['postal'];?>" onfocus="this.value='';" onblur="if(this.value==''){this.value='<?php echo $data['postal'];?>';}" />
										  </div>
										  
										  <div>
										  <label for="tel">Télephone :</label> <!-- Telephone  -->
										  <input type="text" name="tel" value="<?php echo $data['tel'];?>" onfocus="this.value='';" onblur="if(this.value==''){this.value='<?php echo $data['tel'];?>';}"/>
										  </div>
										  
										  <input type="submit" class="submit_button" value="Modifier" />
				  
										</form>
								</div>
								
							</div>
					</div> <!-- End Bloc 01 -->
					
					<div class="bloc02_profil"> <!-- Bloc note -->
						
						<p id="puce_note_profil"> Note - Joueur : </p>
						<div class="bloc_gris_beta">
						
						<p> Cette fonctionnalité n'est pas disponible pour la bêta du site </p>
						</div>
					
					
					</div> <!-- End bloc note -->
					
				</div> <!-- End bloc haut profil -->
				
				<div class="clear"></div>
				
				<div id="milieu_profil"> <!-- Milieu profil -->
					
					<div class="bloc03_profil"> <!-- Bloc 03 -->
						<h3 id="amis_profil"> Amis </h3>
						<div class="bloc_gris_beta01">
						<p> Cette fonctionnalité n'est pas disponible pour la bêta du site </p>
						</div>
						<!--<ul>
							<li> 
								 <a href="#" title=""> Julien Leroux </a> 
								 <p> 4 ami(e)s en commun </p>
							</li>
							<li> 
								 <a href="#" title=""> Julien Leroux </a> 
								 <p> 4 ami(e)s en commun </p>
							</li>
							<li> 
								 <a href="#" title=""> Julien Leroux </a> 
								 <p> 4 ami(e)s en commun </p>
							</li>
							<li> 
								 <a href="#" title=""> Julien Leroux </a> 
								 <p> 4 ami(e)s en commun </p>
							</li>
							<li> 
								 <a href="#" title=""> Julien Leroux </a> 
								 <p> 4 ami(e)s en commun </p>
							</li>
							<li> 
								 <a href="#" title=""> Julien Leroux </a> 
								 <p> 4 ami(e)s en commun </p>
							</li>
							 <?php
               /* $d = $friend->getFriends();
                  
                  foreach ($d as $f)
                  {
                    echo '
    								 <li><a href="#" title=""> '.$f['fname'].' '.$f['lname'].' </a> 
    								 <p> 4 ami(e)s en commun </p>
    							</li>';
                  }*/
              ?> 
						</ul> -->
						<div class="clear"></div>
						
						<!-- <a  class="lien_profil" href="#" title="Voir tous les amis"> Voir tous les amis </a>-->
					</div> <!-- End bloc 03 -->
				
					<div class="bloc04_profil"> <!-- Bloc 04 -->
						<h3 id="commentaire_profil"> Commentaires </h3>
						
						<div class="bloc_gris_beta02">
						<p> Cette fonctionnalité n'est pas disponible pour la bêta du site </p>
						</div>
						<!-- <ul>
							<li> 
								<a href="#" title=""> Foot à Courbevoie </a> 
								<p> « Praeceps Maximini illius obstinatum rects.» </p>
							</li>
							<li> 
								<a href="#" title=""> Rugby à Versailles </a> 
								<p> « Praeceps Maximini illius obstinatum rects.» </p>
							</li>
							<li> 
								<a href="#" title=""> Rugby à Versailles </a> 
								<p> « Praeceps Maximini illius obstinatum rects.» </p>
							</li>
						</ul>
						
						
						<a  class="lien_droite_profil" href="#" title="Voir tous les commentaires"> Voir tous les commentaires </a> -->
						
						<div class="clear"></div>
					</div> <!-- End bloc 03 -->
					
				</div> <!-- End bloc milieu -->
				
				<div class="clear"></div>
				
				<div id="bas_profil"> <!-- bloc bas -->
				
					<div class="bloc05_profil"> <!-- Bloc 05 -->
						<h3 id="statistique_profil"> Statistiques </h3>
						
						<div class="bloc_gris_beta01">
						<p> Cette fonctionnalité n'est pas disponible pour la bêta du site </p>
						</div>
						<!-- <img src="templates/images/stat_profil.png" title="Statistiques profil" />
						End Bloc 05 -->
					</div>
					<div class="bloc06_profil"> <!-- Bloc 06 -->
						<h3 id="sport_profil"> Sports préférés </h3>
						<div class="bloc_gris_beta02">
						<p> Cette fonctionnalité n'est pas disponible pour la bêta du site </p>
						</div>
						<!-- <ul>
							<li> 1 - Rugby    <img src="templates/images/rugby_profil.png" title="Rugby" /> <span class="participer_profil"> Participé à 4 matchs </span> </li>
							<li> 2 - Rugby <img src="templates/images/rugby_profil.png" title="Rugby" /> <span class="participer_profil"> Participé à 2 matchs </span> </li>
							<li> 3 - Rugby    <img src="templates/images/rugby_profil.png" title="Rugby" /> <span class="participer_profil"> Participé à 4 matchs </span> </li>				
						</ul>
						
						<a  class="lien_droite_profil" href="#" title="Voir tous les sports"> Voir tous les sports </a>
					</div> End Bloc 06 -->
					<div class="clear"></div>
				</div> <!-- end bloc bas -->
				
			<div class="clear"></div>
			
			<div id="footer">
				<?php include "templates/footer.php" ; ?>
			</div>
		</div>
	</div>
		
	
	


</body>

</html>
	