<?php
session_start();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="author" content="Niklas" />
	<meta name="contact" content="" />

	<title> SportBook </title>
	
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
	

		
		</div> <!-- End header -->
	
		<div id="conteneur_body">
		
			<?php
			if(!empty($_SESSION['users'])){
			?>
				<div id="navigation">
				
					<?php include "templates/navigation.php" ; ?>
				
				</div>
				<div class="clear"></div>
				
			<?php
			}
			?>
			
			
			<div id="search_ok">
				
				<?php
				

			  
			  
		
			  try{
			  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
			  $bdd->exec('SET NAMES utf8');
			  }
			  
			  catch(Exeption $e){
			  die('Erreur:'.$e->getMessage());
			  }
			  
			  extract($_POST);
			

			
			if(!empty($participants) && !empty($sport) && empty($qdate)){
			  
			  $req = $bdd->query("SELECT * FROM event WHERE sport LIKE '%$sport' AND participants <= '$participants'");
			  if($req->rowCount()>0) {
				while($data = $req->fetch(PDO::FETCH_OBJ)){
				
					echo '<div class="conteneur_resultat">';
						echo '<div id="search_resultats">';
							echo '<h2><a href="voir_event.php?id='.$data->id.'">'.$data->etitle.'</a></h2>';
							echo '<p class="orga_resultat"> Par <span class="orange_resultat">'.$data->ename.'</span></p>';
							echo '<p class="date_resultat">'.$data->qdate.'</p>';
							echo '<p class="lieu_resultat"><span class="orange_resultat">'.$data->lieu.'</span></p>';
							echo '<img class="map_resultat" src="http://maps.googleapis.com/maps/api/staticmap?center='.$data->lieu.';&zoom=15&size=212x90&markers=color:red%7Clabel:A%7C'.$data->lieu.'&sensor=false" alt="Google Map" />';
						echo '</div>';
					
						echo '<div id="droite_resultats">';
							if( $data->sport == 'football') {
								echo '<img src="templates/images/imgfoot.png"/>';
								};
							if( $data->sport == 'Rugby') {
								echo '<img src="templates/images/imgrugby.png"/>';
								};
							if( $data->sport == 'Running') {
								echo '<img src="templates/images/imgrunning.png"/>';
								};
							if( $data->sport == 'Basketball') {
								echo '<img src="templates/images/imgbasket.png"/>';
								};
							if( $data->sport == 'Tennis') {
								echo '<img src="templates/images/imgtennis.png"/>';
								};
							echo '<p class="sport_resultat">'.$data->sport.'</p>';
							echo '<div class="clear"></div>';
							echo '<p class="participants_resultat"><span class="orange_resultat"> Participants ('.$data->participants.')</p>';
							
							echo '<ul class="list_resultat">';
								echo '<li>Loremp Ipsum </li>';
								echo '<li>Loremp Ipsum </li>';
								echo '<li>Loremp Ipsum </li>';
							echo '</ul>';
							
							echo '<p class="a_participants"><a href="voir_event.php?id='.$data->id.'">Voir tous les participants</a></p>';
						
						echo '</div>';
						
						echo '<div class="clear"></div>';
						
					echo '</div>';
					
					}
				}
			}
			
			if(!empty($participants) && !empty($sport) && !empty($qdate)){
			  
			  $req = $bdd->query("SELECT * FROM event WHERE sport LIKE '%$sport' AND participants <= '$participants' AND qdate LIKE '$qdate'");
			  if($req->rowCount()>0) {
				while($data = $req->fetch(PDO::FETCH_OBJ)){
				
					echo '<div class="conteneur_resultat">';
						echo '<div id="search_resultats">';
							echo '<h2><a href="voir_event.php?id='.$data->id.'">'.$data->etitle.'</a></h2>';
							echo '<p class="orga_resultat"> Par <span class="orange_resultat">'.$data->ename.'</span></p>';
							echo '<p class="date_resultat">'.$data->qdate.'</p>';
							echo '<p class="lieu_resultat"><span class="orange_resultat">'.$data->lieu.'</span></p>';
							echo '<img class="map_resultat" src="http://maps.googleapis.com/maps/api/staticmap?center='.$data->lieu.';&zoom=15&size=212x90&markers=color:red%7Clabel:A%7C'.$data->lieu.'&sensor=false" alt="Google Map" />';
						echo '</div>';
					
						echo '<div id="droite_resultats">';
							if( $data->sport == 'football') {
								echo '<img src="templates/images/imgfoot.png"/>';
								};
							if( $data->sport == 'Rugby') {
								echo '<img src="templates/images/imgrugby.png"/>';
								};
							if( $data->sport == 'Running') {
								echo '<img src="templates/images/imgrunning.png"/>';
								};
							if( $data->sport == 'Basketball') {
								echo '<img src="templates/images/imgbasket.png"/>';
								};
							if( $data->sport == 'Tennis') {
								echo '<img src="templates/images/imgtennis.png"/>';
								};
							echo '<p class="sport_resultat">'.$data->sport.'</p>';
							echo '<div class="clear"></div>';
							echo '<p class="participants_resultat"><span class="orange_resultat"> Participants ('.$data->participants.')</p>';
							
							echo '<ul class="list_resultat">';
								echo '<li>Loremp Ipsum </li>';
								echo '<li>Loremp Ipsum </li>';
								echo '<li>Loremp Ipsum </li>';
							echo '</ul>';
							
							echo '<p class="a_participants"><a href="voir_event.php?id='.$data->id.'">Voir tous les participants</a></p>';
						
						echo '</div>';
						
						echo '<div class="clear"></div>';
						
					echo '</div>';
					
					}
				}
				
				else {
					echo '<h2> Aucun Résultat, vous pouvez refaire une recherche :  </h2>';
					
					echo '<div class="search_event">';
					echo '<h2> RECHERCHER UN EVENEMENT </h2> ';
					echo '<form id="signupForm" action="search.php" method="post">';
					
					echo '<div class="desc_search">';
					 echo '<label for="sport"> Sport :</label> <!-- Sport -->';
					 echo ' <select name="sport">';
						echo '	<option value="Football">Football</option>';
						echo '	<option value="Rugby">Rugby</option>';
						echo '	<option value="Running">Running</option>';
						echo '	<option value="Tennis">Tennis</option>';
						echo '	<option value="Basketball">Basketball</option>';
					 echo ' </select>';
					echo '</div> ';
					
					echo '<div class="desc_search">';
						echo '<label for="participants"> Participants :</label> <!-- Lieu -->';
						echo '<select id="sport" name="participants">';
						echo '	<option value=""> </option>';
						echo '	<option value="< = "> < = </option>';
						echo '	<option value="1">1</option>';
						echo '	<option value="2">2</option>';
						echo '	<option value="3">3</option>';
						echo '	<option value="4">4</option>';
						echo '	<option value="5">5</option>';
						echo '	<option value="6">6</option>';
						echo '	<option value="7">7</option>';
						echo '	<option value="8">8</option>';
						echo '	<option value="9">9</option>';
						echo '	<option value="10">10</option>';
						echo '	<option value="11">11</option>';
						echo '	<option value="12">12</option>';
						echo '	<option value="13">13</option>';
						echo '	<option value="14">14</option>';
						echo '	<option value="15">15</option>';
						echo '	<option value="16">16</option>';
						echo '	<option value="17">17</option>';
						echo '	<option value="18">18</option>';
						echo '	<option value="19">19</option>';
						echo '	<option value="20">20</option>';
						echo '	<option value="21">21</option>';
						echo '	<option value="22">22</option>';
						echo '</select>';
					echo '</div>';
					
					echo '<div class="desc_search2">';
					 echo '  <label for="qdate"> Date : </label>';
					   echo '<input id="qdate" name="qdate" type="text" />';
					echo '</div>';
					
						echo '<input type="submit" value="OK" />';
		
					echo '</form>';
					echo '</div>';
				}
			}
			
			if(empty($participants) && !empty($sport) && empty($qdate)){
			  
			  $req = $bdd->query("SELECT * FROM event WHERE sport LIKE '%$sport'");
			  if($req->rowCount()>0) {
				while($data = $req->fetch(PDO::FETCH_OBJ)){
				
					echo '<div class="conteneur_resultat">';
						echo '<div id="search_resultats">';
							echo '<h2><a href="voir_event.php?id='.$data->id.'">'.$data->etitle.'</a></h2>';
							echo '<p class="orga_resultat"> Par <span class="orange_resultat">'.$data->ename.'</span></p>';
							echo '<p class="date_resultat">'.$data->qdate.'</p>';
							echo '<p class="lieu_resultat"><span class="orange_resultat">'.$data->lieu.'</span></p>';
							echo '<img class="map_resultat" src="http://maps.googleapis.com/maps/api/staticmap?center='.$data->lieu.';&zoom=15&size=212x90&markers=color:red%7Clabel:A%7C'.$data->lieu.'&sensor=false" alt="Google Map" />';
						echo '</div>';
					
						echo '<div id="droite_resultats">';
							if( $data->sport == 'football') {
								echo '<img src="templates/images/imgfoot.png"/>';
								};
							if( $data->sport == 'Rugby') {
								echo '<img src="templates/images/imgrugby.png"/>';
								};
							if( $data->sport == 'Running') {
								echo '<img src="templates/images/imgrunning.png"/>';
								};
							if( $data->sport == 'Basketball') {
								echo '<img src="templates/images/imgbasket.png"/>';
								};
							if( $data->sport == 'Tennis') {
								echo '<img src="templates/images/imgtennis.png"/>';
								};
							echo '<p class="sport_resultat">'.$data->sport.'</p>';
							echo '<div class="clear"></div>';
							echo '<p class="participants_resultat"><span class="orange_resultat"> Participants ('.$data->participants.')</p>';
							
							echo '<ul class="list_resultat">';
								echo '<li>Loremp Ipsum </li>';
								echo '<li>Loremp Ipsum </li>';
								echo '<li>Loremp Ipsum </li>';
							echo '</ul>';
							
							echo '<p class="a_participants"><a href="voir_event.php?id='.$data->id.'">Voir tous les participants</a></p>';
						
						echo '</div>';
						
						echo '<div class="clear"></div>';
						
					echo '</div>';
					
					}
				}
			}
			
			
		
	
			  

			?>
		
			</div>
			
			
			<div class="clear"></div>
			
			<div id="footer">
				<?php include "templates/footer.php" ; ?>
			</div>
		</div>
	
		
	
	


</body>

</html>
	