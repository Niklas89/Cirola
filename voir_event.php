<?php
session_start();
include 'function/verification_session.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="author" content="Niklas" />
	<meta name="contact" content="" />

	<title> Évènement | Cirola.com </title>
	
	<link rel="stylesheet" type="text/css" href="templates/css/style.css" />
		<script src="js/jquery-1.7.1.js"></script>
		<script src="js/jquery.ui.core.js"></script>
		<script src="js/jquery.ui.widget.js"></script>
		<script src="js/jquery.ui.datepicker.js"></script>
	
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
		
	
	
	
	
</head>

<body>


	<div id="conteneur">
	
		<?php include "templates/logo.html" ; ?>
	
		<div id="header"> <!-- Header -->
			<?php if(isset($erreurid)) echo '<div class="badlogin">'.$erreurid.'</div>';?>
			
			<div id="login"> <!-- Login -->
			
				 <?php
				if(empty($_SESSION['users'])){
				?>
				<form id="signupForm" action="index.php" method="post">
						
						<div>
						<input type="text" name="login" value="Login :"  onFocus="this.value='';" onBlur="if(this.value==''){this.value='Login :';}" />
						</div>
						
						<div>
						<input type="password" name="pass" value="Mot de passe :" onFocus="this.value='';" onBlur="if(this.value==''){this.value='Mot de passe : ';}" />
						</div>
						
						
						<a href="oublie.php" id="oublie" title="Mot de passe oublié?"> Mot de passe oublié </a>
						
						<input type="submit" class="submit_button" value="Log In" />
				</form>
			
			
					
				<?php
					}
					else{
				?>	
					<div id="logout">
						<h2><span class="orange"> <?php echo $_SESSION['users'];?> </span></h2>
						<p> <a href="logout.php"> Déconnection </a> </p>
					</div>
				<?php
					}
				?>
		
			</div> <!-- End login -->
		
		</div> <!-- End header -->
	
		<div id="conteneur_body">
		
			<?php
			if(empty($_SESSION['users'])){
			?>
				<div id="login_off">
				
					<?php include "templates/presentation.php" ; ?>
				
				</div>
				
			<?php
			}
			else{
			?>
				<div id="navigation">
				
					<?php include "templates/navigation.php" ; ?>
				
				</div>
				<div class="clear"></div>
			<?php
			}
			?>
			
			

			<div id="voir_event">
<?php

		

		try{
		  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
		  $bdd->exec('SET NAMES utf8');
		  
		  
		  		// si qqun a cliqué sur "Participer" on l'enregistre comme "en attente"
		if(isset($_GET['part'])){
					$participer = $_GET['part'];
					$userid =  $_SESSION['id'];
					$req = $bdd->query("INSERT INTO users_has_event (fk_users, fk_users_attente, fk_event, fk_event_attente) VALUES ('$userid','$userid','$participer','$participer')");
					// $req = $bdd->query("UPDATE users SET attente_participer = ".$participer." WHERE id = ".$userid);
					
					echo '<script language="Javascript">
							<!--
							document.location.replace("voir_event.php?id='.$_GET['part'].'");
							// -->
							</script>';
							
					// echo '<h3>Vous êtes en attente de confirmation.</h3>';
					
					
		}
		// si qqun a cliqué sur "Se désinscrire" on le supprimer de la table users_has_event
		if(isset($_GET['annuler'])){
					$userid =  $_SESSION['id'];
					//$req = $bdd->query("UPDATE users_has_event SET fk_users_attente = 0 WHERE fk_users_attente = ".$userid);
					$req = $bdd->query("DELETE FROM users_has_event WHERE fk_users_attente =".$userid." AND fk_event =".$_GET['annuler']);
					
					echo '<script language="Javascript">
							<!--
							document.location.replace("voir_event.php?id='.$_GET['annuler'].'");
							// -->
							</script>';
							
					// echo '<h3>Vous êtes bien désinscrit.</h3>';
					
		}
		
		// si qqun valide comme participant a cliqué sur "Se désinscrire" on le supprimer de la table users_has_event
		if(isset($_GET['valannuler'])){
					$userid =  $_SESSION['id'];
					//$req = $bdd->query("UPDATE users SET valide_participer = 0 WHERE id = ".$userid);
					$req = $bdd->query("DELETE FROM users_has_event WHERE fk_users_valide =".$userid." AND fk_event =".$_GET['valannuler']);
					
					echo '<script language="Javascript">
							<!--
							document.location.replace("voir_event.php?id='.$_GET['valannuler'].'");
							// -->
							</script>';
							
					// echo '<h3>Vous êtes bien désinscrit.</h3>';
					
		}
		  
		  
		  
		  $reponse = $bdd->query('SELECT * FROM event WHERE id='.$_GET['id']);
		while ($row = $reponse->fetch())
		{ $event_participants = $row['participants'];
		?>
		
			<?php
				date_default_timezone_set('Europe/Madrid');
				$event_date_db = $row['qdate'];
				$event_date = date('Y-m-d', strtotime($event_date_db));
				
				$d1 = new DateTime('now');
				$d2 = new DateTime($event_date);
			?>
			<h2><?php echo $row['etitle']; ?></h2>
			<div class="voir_event_details"><img class="details_event_left" src="templates/images/icone_message.png" alt="Icone Message" /><p class="voir_event_right">Evènement uniquement sur invitation - Par <strong class="voir_event_ename"><?php echo $row['ename'] ?></strong><br />Crée le <?php echo date('d-m-Y \à H:i:s', strtotime($row['edate'])); ?></p></div>
			<div class="separation"></div>
			
			<div class="voir_event_details"><img class="details_event_left_qdate" src="templates/images/icone_calendrier.png" alt="Icone Message" /><p class="voir_event_right"><span class="voir_event_qdate"><?php echo date('d-m-Y', strtotime($row['qdate'])); ?></span><img class="voir_event_icone_heure" src="templates/images/icone_heure.png" alt="Icone Message" /><span class="voir_event_qtime"><?php echo $row['qtime']; ?></span></p></div>
			<div class="separation"></div>
			
			<div class="voir_event_details"><img class="details_event_left" src="templates/images/icone_texte.png" alt="Icone Message" /><p class="voir_event_right" class="voir_event_description"><?php echo $row['description']; ?></p></div>
			
			<?php if(!empty($_SESSION['users'])){
					$users=$_SESSION['users']; ?>
			<div class="separation"></div>
			<?php $reponse = $bdd->query('SELECT * FROM users_has_event WHERE fk_users_valide = '.$_SESSION['id'].' AND fk_event = '.$_GET['id']);
				if ($rdvrow = $reponse->fetch())
				{ ?>
				<div class="voir_event_detailsrdv"><img class="details_event_left_lieu" src="templates/images/icone_lieu.png" alt="Icone Message" /><p class="voir_event_lieu">RDV: <?php echo $row['lieurdv']; ?></p></div>
				<div class="separation"></div>
				<?php }
				elseif ($row['ename'] == $_SESSION['users']) { ?>
				<div class="voir_event_detailsrdv"><img class="details_event_left_lieu" src="templates/images/icone_lieu.png" alt="Icone Message" /><p class="voir_event_lieu">RDV: <?php echo $row['lieurdv']; ?></p></div>
				<div class="separation"></div>
				<?php } ?>
				
			<div class="voir_event_details"><img class="details_event_left_lieu" src="templates/images/icone_lieu.png" alt="Icone Message" /><p class="voir_event_lieu"><?php echo $row['lieu']; ?></p></div>
			<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $row['lieu']; ?>&zoom=15&size=560x300&markers=color:red%7Clabel:A%7C<?php echo $row['lieu']; ?>&sensor=false" alt="Google Map" />
			<?php } // if !empty user ?>
				
			</div> <!-- voir_event -->
			
			<div id="voir_event_bloc_droit">
				<div class="voir_event_sport">
					<?php if($row['sport'] == 'Football'){ ?>
						<img class="voir_event_titre_img" src="templates/images/imgfoot.png" alt="Football" />
					<?php } ?>
					<?php if($row['sport'] == 'Running'){ ?>
						<img class="voir_event_titre_img" src="templates/images/imgrunning.png" alt="Running" />
					<?php } ?>
					<?php if($row['sport'] == 'Rugby'){ ?>
						<img class="voir_event_titre_img" src="templates/images/imgrugby.png" alt="Rugby" />
					<?php } ?>
					<?php if($row['sport'] == 'Basketball'){ ?>
						<img class="voir_event_titre_img" src="templates/images/imgbasket.png" alt="Basketball" />
					<?php } ?>
					<?php if($row['sport'] == 'Tennis'){ ?>
						<img class="voir_event_titre_img" src="templates/images/imgtennis.png" alt="Tennis" />
					<?php } ?>
					<h3><?php echo $row['sport']; ?><h3>
				</div>
				
				<?php if(!empty($_SESSION['users'])){ // si on est logué
						$users=$_SESSION['users']; ?>	
				<div class="voir_event_bloc">
				
					<?php // si qqun est refusé à participer
					if(isset($_GET['refu'])){
							$req = $bdd->query("UPDATE users_has_event SET fk_users_attente = 0, fk_event_attente = 0 WHERE fk_users = ".$_GET['refu']." AND fk_event = ".$_GET['id']);
							$req = $bdd->query("UPDATE users_has_event SET fk_users_refuse = ".$_GET['refu'].", fk_event_refuse = ".$_GET['id']." WHERE fk_users = ".$_GET['refu']." AND fk_event = ".$_GET['id']);
							
							//envoi du mail de notification à celui qui est refusé
							$reponse = $bdd->query('SELECT * FROM users WHERE id = '.$_GET['refu']);
							while ($mail = $reponse->fetch()) //selectionner l'email du participant
							{ 
							
								$to = $mail['email'];
								$subject = 'Participation sur Cirola';
								$message = 'Bonjour '.$mail['fname'].',<br /><br />On est désolé de vous annoncer que vous avez été refusé de participer à un évènement.<br />
								Veuillez vous rendre sur <a href="http://cirola.com/Sportbook/voir_event.php?id='.$_GET['id'].'" title="cirola">Cirola.com</a> de quel évènement il s\'agit.
								<br /><br />Cordialement,<br />Cirola.com' ;
								
								$tpl = file_get_contents('templates/email_template.html');
								$tpl = str_replace('{{subject}}', $subject, $tpl);
								$tpl = str_replace('{{message}}', $message, $tpl);
								
								$headers = 'From:noreply@cirola.com'."\r\n";
								$headers.='MIME-version: 1.0'."\r\n";
								$headers.='Content-type: text/html; charset=utf-8'."\r\n";
								mail($to,$subject,$tpl,$headers);
							}
							
							echo '<script language="Javascript">
							<!--
							document.location.replace("voir_event.php?id='.$_GET['id'].'");
							// -->
							</script>';
							
					}
					// si qqun est accepté à participer
					if(isset($_GET['valid'])){
							$req = $bdd->query("UPDATE users_has_event SET fk_users_attente = 0, fk_event_attente = 0 WHERE fk_users = ".$_GET['valid']." AND fk_event = ".$_GET['id']);
							$req = $bdd->query("UPDATE users_has_event SET fk_users_valide = ".$_GET['valid'].", fk_event_valide = ".$_GET['id']." WHERE fk_users = ".$_GET['valid']." AND fk_event = ".$_GET['id']);
							
							//envoi du mail de notification à celui qui est accepté
							$reponse = $bdd->query('SELECT * FROM users WHERE id = '.$_GET['valid']);
							while ($mail = $reponse->fetch()) //selectionner l'email du participant
							{ 
							
								$to = $mail['email'];
								$subject = 'Participation sur Cirola';
								$message = 'Bonjour '.$mail['fname'].',<br /><br />Vous avez été accepté de participer à un évènement sur Cirola.<br />
								Veuillez vous rendre sur <a href="http://cirola.com/Sportbook/voir_event.php?id='.$_GET['id'].'" title="cirola">Cirola.com</a> pour voir le lieu de rendez-vous.
								<br /><br />Attention: vous devez être connecté pour voir le lieu!<br /><br />Cordialement,<br />Cirola.com' ;
								
								$tpl = file_get_contents('templates/email_template.html');
								$tpl = str_replace('{{subject}}', $subject, $tpl);
								$tpl = str_replace('{{message}}', $message, $tpl);
								
								$headers = 'From:noreply@cirola.com'."\r\n";
								$headers.='MIME-version: 1.0'."\r\n";
								$headers.='Content-type: text/html; charset=utf-8'."\r\n";
								mail($to,$subject,$tpl,$headers);
								
							}
							
							echo '<script language="Javascript">
							<!--
							document.location.replace("voir_event.php?id='.$_GET['id'].'");
							// -->
							</script>';
							
					} ?>
				
				
				
					<?php $reponse = $bdd->query('SELECT COUNT(*) FROM users_has_event WHERE fk_event_valide = '.$_GET['id']);
						while ($count = $reponse->fetch()) //compter les participants
						{ ?>
					<h3><img class="voir_event_icone_participants" src="templates/images/icone_participants.png" alt="Icone Participants" />Participants ( <?php echo $count[0]; ?>/<?php echo $event_participants; ?> )</h3>
						<?php } //end boucle compter
						?>
					<ul>
					
					
					 <?php
					if(isset($_GET['voirtous'])){
						$reponse = $bdd->query('SELECT * FROM users_has_event,users WHERE users_has_event.fk_event_valide = '.$_GET['id'].' AND users.id = fk_users');
					}
					elseif(isset($_GET['voirlimit'])) {
						$reponse = $bdd->query('SELECT * FROM users_has_event,users WHERE users_has_event.fk_event_valide = '.$_GET['id'].' AND users.id = fk_users LIMIT 5');
					}
					else {
						$reponse = $bdd->query('SELECT * FROM users_has_event,users WHERE users_has_event.fk_event_valide = '.$_GET['id'].' AND users.id = fk_users LIMIT 5');
					}
						while ($roww = $reponse->fetch())
						{ ?>
						<li><img class="voir_event_liste_participants" src="templates/images/perso.png" alt="Participants" /><?php echo $roww['login']; ?></li>
						<?php } ?>
					</ul>
					<?php if(isset($_GET['voirtous'])){ ?>
						<p><a href="voir_event.php?id=<?php echo $_GET['id']; ?>&voirlimit=<?php echo $_GET['id']; ?>">Replier la liste</a></p>	
					<?php } else { ?>
						<p><a href="voir_event.php?id=<?php echo $_GET['id']; ?>&voirtous=<?php echo $_GET['id']; ?>">Voir tous les participants</a></p>
					<?php } ?>
				</div>
				
				
				<!-- Les "en attente" -->
				
				
				<div class="voir_event_bloc">
					<?php $reponse = $bdd->query('SELECT COUNT(*) FROM users_has_event WHERE fk_event_attente = '.$_GET['id']);
						while ($count = $reponse->fetch()) //compter les participants
						{ ?>
					<h3><img class="voir_event_icone_participants" src="templates/images/icone_participants.png" alt="Icone Participants" />En Attente ( <?php echo $count[0]; ?> )</h3>
						<?php } //end boucle compter
						?>
					<ul>
					<?php
					$reponse = $bdd->query('SELECT * FROM users_has_event,users WHERE users_has_event.fk_event_attente = '.$_GET['id'].' AND users.id = fk_users');
						while ($roww = $reponse->fetch())
						{ ?>
						<li>
						<?php if($row['ename'] == $_SESSION['users']){ //si l'organisateur = à celui qui est connecté ?>
						<?php echo '<a href="voir_event.php?id='.$_GET['id'].'&valid='.$roww['id'].'"><img src="templates/images/vrai_liste.png" alt="valider" /></a> - <a href="voir_event.php?id='.$_GET['id'].'&refu='.$roww['id'].'"><img src="templates/images/faux_liste.png" alt="refuser" /></a> - ';
							?><?php echo $roww['login']; ?>
						<?php } else { ?>
							
							<img class="voir_event_liste_participants" src="templates/images/perso.png" alt="Participants" /><?php echo $roww['login']; ?>
							<?php } ?>
							
						<?php } //end while ?>
						
						</li>
						
					</ul>
						
				</div>
				
				<!-- Les participants refusés -->
				<div class="voir_event_bloc">
					<?php $reponse = $bdd->query('SELECT COUNT(*) FROM users_has_event WHERE fk_event_refuse = '.$_GET['id']);
						while ($count = $reponse->fetch()) //compter les participants
						{ ?>
					<h3><img class="voir_event_icone_participants" src="templates/images/icone_participants.png" alt="Icone Participants" />Refusé ( <?php echo $count[0]; ?> )</h3>
						<?php } //end boucle compter
						?>
					<ul>
					<?php
					$reponse = $bdd->query('SELECT * FROM users_has_event,users WHERE users_has_event.fk_event_refuse = '.$_GET['id'].' AND users.id = fk_users');
						while ($roww = $reponse->fetch())
						{ ?>
						<li><img class="voir_event_liste_participants" src="templates/images/perso.png" alt="Participants" /><?php echo $roww['login']; ?>
						</li>
						<?php } ?>
					</ul>
						
				</div> 
				
				
				
				<!-- les invités -->
				<!--<div class="voir_event_bloc">
					<h3><img class="voir_event_icone_participants" src="templates/images/icone_participants.png" alt="Icone Participants" />Invités ( 10 )</h3>
					<ul>
						<li><img class="voir_event_liste_participants" src="templates/images/perso.png" alt="Participants" />Loremp Ipsum </li>
						<li><img class="voir_event_liste_participants" src="templates/images/perso.png" alt="Participants" />Loremp Ipsum </li>
						<li><img class="voir_event_liste_participants" src="templates/images/perso.png" alt="Participants" />Loremp Ipsum </li>
						<li><img class="voir_event_liste_participants" src="templates/images/perso.png" alt="Participants" />Loremp Ipsum </li>
					</ul>
						<p>Voir tous les invités</p>
				</div>-->
				
				
				<?php } // if !empty user
				
				
				
				
				
					else { ?>
				<div class="voir_event_bloc">
					<?php $reponse = $bdd->query('SELECT COUNT(*) FROM users_has_event WHERE fk_event_valide = '.$_GET['id']);
						while ($count = $reponse->fetch()) //compter les participants
						{ ?>
					<h3><img class="voir_event_icone_participants" src="templates/images/icone_participants.png" alt="Icone Participants" />Participants ( <?php echo $count[0]; ?> )</h3>
						<?php } //end boucle compter
						?>
				</div>
				<?php } ?>
				
			<?php if(!empty($_SESSION['users'])){
				$users=$_SESSION['users']; ?>	
				<?php error_reporting(0); if($row['ename'] == $_SESSION['users']){ ?>
				<div class="voir_event_bouton_valid">
					<form id="signupForm" action="index.php" method="post">
					<?php // si la date d'aujoud'hui est inférieur à la date de l'event (calculé en haut)
					if($d1 >= $d2){ 
					echo '<p class="cestcomplet">Évènement terminé.</p>'; } ?>
					</form>
					<a href="#?w=500" rel="popup_annuler" class="poplight"  title="Annuler">Annuler l'évènement</a>
					<div id="popup_annuler" class="popup_block">
						<h2>Etes vous sûr de vouloir annuler l'évènement?</h2>
						<p>Cela supprimera toutes ses données.</p>
						<form id="signupForm" action="annuler_event.php" method="post">
							<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
							<input type="submit" class="submit_button" value="OUI" />
						</form>
					</div>
				</div>
				<div class="voir_event_social"></div>
				<?php } else {?> 
				<div class="voir_event_bouton_valid">
					<form id="signupForm" action="voir_event.php" method="get">
					<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
					<input type="hidden" name="part" value="<?php echo $_GET['id']; ?>" />
					
					
					<?php //afficher le lien pour se désinscrire ou le bouton participer
					
					// si la date d'aujoud'hui est inférieur à la date de l'event (calculé en haut)
					if($d1 < $d2){
					
					$reponse = $bdd->query('SELECT * FROM users_has_event WHERE fk_users_attente ='.$_SESSION['id'].'  AND fk_event ='.$_GET['id'].' OR fk_users_valide='.$_SESSION['id'].' AND fk_event ='.$_GET['id'].'
							       OR fk_users_refuse='.$_SESSION['id'].' AND fk_event ='.$_GET['id']);
					if ($lien = $reponse->fetch())
					{ 
						if ($lien['fk_users_attente'] == $_SESSION['id']){ ?>
					</form>
					<div class="desinscrire"><a href="voir_event.php?id=<?php echo $_GET['id']; ?>&annuler=<?php echo $_GET['id']; ?>" title="Annuler">Se désinscrire</a></div>
					<?php	}
						elseif ($lien['fk_users_valide'] == $_SESSION['id']){ ?>
					</form>
					<div class="desinscrire"><a href="voir_event.php?id=<?php echo $_GET['id']; ?>&valannuler=<?php echo $_GET['id']; ?>" title="Annuler">Se désinscrire</a></div>
					<?php	}
						elseif ($lien['fk_users_refuse'] == $_SESSION['id']){ ?>
					</form>
					
					<?php	}
						
					}
						else {
							// compte le nombre de participants valide et selectionne le nombre de participants max de levent. si les deux sont égales on ne peux plus participer
							$countparticipants = $bdd->query('SELECT COUNT(*),participants FROM users_has_event,event WHERE users_has_event.fk_event_valide = '.$_GET['id'].' AND event.id = '.$_GET['id']);
							if ($participants = $countparticipants->fetch())
							{
								if($participants[1] == $participants[0]) { echo "<p class='cestcomplet'>Évènement complet.</p></form>"; }
								else {  ?> <input type="submit" class="submit_button" value="Participer à l'évènement" /> </form>
								<?php }
							}
							
						}
					
					?>
					
						
					
				</div>
				<div class="voir_event_social"></div>
				<?php } //end $d1<$d2
				else { echo '<p class="cestcomplet">Évènement terminé.</p></form></div>'; }
				} 
				?>
			<?php } // if !empty user 
					else { ?>
				<div class="voir_event_bouton_valid">
					<form id="signupForm" action="inscription.php" method="post">
					<input type="submit" class="submit_button" value="S'inscrire" />
					</form>
					
				</div>
				<?php } ?>
				
				
			</div>
			
			<div class="clear"></div>
			
			<div id="footer">
				<?php include "templates/footer.php" ; ?>
			</div>
		</div>
	</div>
		
	
		 <?php }
		$reponse->closeCursor();
		  
		  }
		  
		  catch(Exeption $e){
		  die('Erreur:'.$e->getMessage());
		  } ?>
		  
		  
		  




</body>

</html>
	