<?php
session_start();

include 'function/verification_session.php';

try{
  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES utf8');
  }
  
  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  }


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="author" content="Niklas" />
	<meta name="contact" content="" />

	<title> Accueil | Cirola.com </title>
	
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
			
			<div id="event">
				
				<div class="search_event">
				
					<h2> RECHERCHER UN EVENEMENT </h2> 
					
					<form id="signupForm" action="search.php" method="post">
					
					<div class="desc_search">
					  <label for="sport"> Sport :</label> <!-- Sport -->
					  <select name="sport">
							 <?php $reponse = $bdd->query('SELECT sport FROM sports');
							 while ($donnees = $reponse->fetch())
							{
							?>
							<option value="<?php echo $donnees['sport']; ?>"><?php echo $donnees['sport']; ?></option>
							 <?php
							}
							$reponse->closeCursor(); ?>
					  </select>
					</div> 
					
					<div class="desc_search">
						<label for="participants"> Participants :</label> <!-- Lieu -->
						<select id="sport" name="participants">
							<option value=""></option>
							<option value="< = "> < = </option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
						
						</select>
					</div>
					 					
					<div class="desc_search2">
					   <label for="qdate"> Date : </label>
					   <input id="qdate" name="qdate" type="text" />
					</div>
					
						<input type="submit" value="OK" name=""/>
		
					</form>
				</div>
				
				<div class="search_event" id="ajustement_search">
				
					<h2> CREER UN EVENEMENT </h2> 
					
					<form id="signupForm" action="creer_event.php" method="post">
					
					<div class="desc_search">
					  <label for="sport"> Sport :</label> <!-- Sport -->
					  <select name="sport">	 	
						<?php
						 try{
						  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
						  $bdd->exec('SET NAMES utf8');
							$reponse = $bdd->query('SELECT sport FROM sports');
							while ($donnees = $reponse->fetch()){ ?>
							    <option value="<?php echo $donnees['sport']; ?>"><?php echo $donnees['sport']; ?></option>
							     <?php
							}
							$reponse->closeCursor();
						}
							catch(Exeption $e){
							die('Erreur:'.$e->getMessage()); } ?>
					  </select>
					</div> 
					
					<div class="desc_search">
					  <label for="participants"> Participants :</label> <!-- Lieu -->
					  <select id="sport" name="participants">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							
					  </select>
					</div>
					 					
					<div class="desc_search2">
					   <label for="qdate"> Date : </label>
					   <input id="qdate2" name="qdate" type="text" />
					</div>
					
						<input type="submit" value="OK" />
		
					</form>
				</div>
				<div class="clear"></div>
			</div>
			
			<div id="last_event">
				
				<h2> NOS DERNIERS EVENEMENTS </h2>
				
				<?php
					 try{
					  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
					  $bdd->exec('SET NAMES utf8');
					  
					  $reponse = $bdd->query('SELECT sport, lieu, qdate, ename,id FROM event ORDER BY id DESC LIMIT 6');
					while ($row = $reponse->fetch())
					{
						echo '<div class="bloc_sport">';
						echo '<a href="voir_event.php?id='.$row['id'].'">';
						echo '<h3>'.$row['sport'].'</h3>'; 
						echo '<p class="distance">Lieu : </span> <span class="grisfonce">'.$row['lieu'].'</span></p>';
						echo '<p>Date : </span> <span class="grisfonce">'.date('d-m-Y', strtotime($row['qdate'])).'</span></p>';
						echo '<p>Créateur : </span> <span class="grisfonce">'.$row['ename'].'</span></p>';
						if( $row['sport'] == 'Football') {
							echo '<img src="templates/images/imgfoot.png"/>';
							};
						if( $row['sport'] == 'Rugby') {
							echo '<img src="templates/images/imgrugby.png"/>';
							};
						if( $row['sport'] == 'Running') {
							echo '<img src="templates/images/imgrunning.png"/>';
							};
						if( $row['sport'] == 'Basketball') {
							echo '<img src="templates/images/imgbasket.png"/>';
							};
						if( $row['sport'] == 'Tennis') {
							echo '<img src="templates/images/imgtennis.png"/>';
							};
						echo '</a>';
						echo '</div>';
						
					}
					$reponse->closeCursor();
					  
					  }
					  
					  catch(Exeption $e){
					  die('Erreur:'.$e->getMessage());
					  }
				?>
			
				<div id="a">
				<a href="allevent.php" title="Voir tous les évènements de Cirola"> Voir tous les évènements </a>
				</div>
			</div>
			
			<div id="bloc_droit">
				
				<div class="bloc">
					<h3> CLASSEMENTS ORGANISATEURS </h3>
					<div class="bloc_gris_beta03">
						<p> Cette fonctionnalité n'est pas disponible pour la bêta du site </p>
					</div>
					<!-- <ul>
						<li> <span class="chiffres"> 1 </span> - Loremp Ipsum </li>
						<li> <span class="chiffres"> 2 </span> - Loremp Ipsum </li>
						<li> <span class="chiffres"> 3 </span> - Loremp Ipsum </li>
						<li> <span class="chiffres"> 4 </span> - Loremp Ipsum </li>
					</ul> -->
				</div>
				
				<div class="bloc" id="classement_participant">
					<h3 class="h3_ajustement"> CLASSEMENTS PARTCIPANTS </h3>
					<div class="bloc_gris_beta03">
						<p> Cette fonctionnalité n'est pas disponible pour la bêta du site </p>
						</div>
					<!-- <ul>
						<li> <span class="chiffres"> 1 </span> - Loremp Ipsum </li>
						<li> <span class="chiffres"> 2 </span> - Loremp Ipsum </li>
						<li> <span class="chiffres"> 3 </span> - Loremp Ipsum </li>
						<li> <span class="chiffres"> 4 </span> - Loremp Ipsum </li>
					</ul>-->
				</div>
				
				<div class="bloc" id="evenements_passes">
					<h3> EVENEMENTS PASSES </h3>
					<div class="bloc_gris_beta03">
						<p> Cette fonctionnalité n'est pas disponible pour la bêta du site </p>
						</div>
					<!-- <ul>
						<li>  Loremp Ipsum </li>
						<li>  Loremp Ipsum </li>
						<li>  Loremp Ipsum </li>
						<li>  Loremp Ipsum </li>
						<li>  Loremp Ipsum </li>
					</ul>-->
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
	