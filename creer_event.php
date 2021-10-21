<?php
session_start();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta charset="utf-8">
	<title>Créer un évènement | Cirola.com</title>
	<link rel="stylesheet" href="templates/css/datepicker/jquery.ui.all.css">
	<script src="lib/js/jquery-1.7.1.js"></script>
	<script src="lib/js/jquery.ui.core.js"></script>
	<script src="lib/js/jquery.ui.widget.js"></script>
	<script src="lib/js/jquery.ui.datepicker.js"></script>
	<script src="lib/js/jquery.validate.js" type="text/javascript"></script>
	<link rel="stylesheet" href="templates/css/datepicker/demos.css">
	<link rel="stylesheet" type="text/css" href="templates/css/style.css" />
	
	
	<script>
	$(function() {
		$( "#qdate" ).datepicker();
	});
	</script>
	
			<script type="text/javascript">
			$.validator.setDefaults({
				submitHandler: function() {  $(form).submit(); }
			});

			$().ready(function() {
				

				// Validation quand on tab ou quand on envoie
				$("#customForm").validate({
					rules: {
						etitle: {
							required: true
						},
						qdate: {
							required: true
						},
						hours: {
							required: true,
						},
						minutes: {
							required: true
						},
						lieu: {
							required: true
						},
						sport: {
							required: true
						},
						description: {
							required: true
						},
						participants: {
							required: true
						},
						lieurdv: {
							required: true
						},
						
					},
					messages: {
						
						etitle: {
							required: "<p class='creer_event_valid'>Entrez le titre s'il vous plaît !</p>"
						},
						qdate: {
							required: "<p class='creer_event_valid'>Entrez la date de l'évènement s'il vous plaît !</p>"
						},
						hours: {
							required: "<p class='creer_event_valid'>Entrez l'heure s'il vous plaît !</p>"
						},
						minutes: {
							required: "<p class='creer_event_valid'>Entrez les minutes s'il vous plaît !</p>"
						},
						lieu: {
							required: "<p class='creer_event_valid'>Entrez le lieu s'il vous plaît !</p>"
						},
						sport: {
							required: "<p class='creer_event_valid'>Entrez le sport s'il vous plaît !</p>"
						},
						
						participants: {
							required: "<p class='creer_event_valid'>Entrez le nombre de participants s'il vous plaît !</p>"
						},
						description: {
							required: "<p class='creer_event_valid'>Entrez une description s'il vous plaît !</p>"
						},
						lieurdv: {
							required: "<p class='creer_event_valid'>Entrez un lieu de rendez-vous s'il vous plaît !</p>"
						},
					}
				});
			});
			</script>
	
	<!-- pour google map -->
	<script src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"
      type="text/javascript"></script>
	  <style type="text/css">
        #map_canvas {
        height: 250px;
        width: 450px;
        margin-top: 0.6em;
      }
    </style>
	
    <script type="text/javascript">
      function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(48.8566667, 2.3509871),
          zoom: 13,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById('map_canvas'),
          mapOptions);

        var input = document.getElementById('searchTextField');
		
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
          map: map
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
          infowindow.close();
          var place = autocomplete.getPlace();
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }

          var image = new google.maps.MarkerImage(
              place.icon,
              new google.maps.Size(71, 71),
              new google.maps.Point(0, 0),
              new google.maps.Point(17, 34),
              new google.maps.Size(35, 35));
          marker.setIcon(image);
          marker.setPosition(place.geometry.location);

          var address = '';
          if (place.address_components) {
            address = [(place.address_components[0] &&
                        place.address_components[0].short_name || ''),
                       (place.address_components[1] &&
                        place.address_components[1].short_name || ''),
                       (place.address_components[2] &&
                        place.address_components[2].short_name || '')
                      ].join(' ');
          }

          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          google.maps.event.addDomListener(radioButton, 'click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
	
</head>
<body>

<?php try{ //Connection à la base de donnée
  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES utf8');
  }
  
  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  } ?>

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
				
					<?php include "templates/presentation_creer_evt.html" ; ?>
				
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
			
			
				<?php
				if(!empty($_SESSION['users'])){
				?>
<div id="creer_event">

		 
	<?php 	
		if(isset($_POST['etitle']) && isset($_POST['lieu']) && isset($_POST['sport']) && isset($_POST['description'])){
	if(!empty($_POST['etitle']) && !empty($_POST['lieu']) && !empty($_POST['sport']) && !empty($_POST['description'])){ 
	
					
						$etitle = $_POST['etitle'];
						$ename = $_SESSION['users'];
						$qdate = $_POST['qdate'];
						$edate = date('Y-m-d H:i:s');
						$hours = $_POST['hours'];
						$minutes = $_POST['minutes'];
						$lieu = $_POST['lieu'];
						$sport = $_POST['sport'];
						$description = $_POST['description'];
						$participants = $_POST['participants'];
						$lieurdv = $_POST['lieurdv'];
						$orga = 1;
						$qtime = $hours.'h'.$minutes; 
						
						$req = $bdd->prepare("INSERT INTO `event`(`id`, `etitle`, `ename`, `edate`, `qdate`, `qtime`, `lieu`, `sport`, `description`, `participants`, `orga`, `lieurdv`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
						$req->execute(array(
						  'NULL',
						  $etitle,	
						  $ename,
						  $edate,
						  $qdate,
						  $qtime,
						  $lieu,
						  $sport,
						  $description,
						  $participants,
						  $orga,
						  $lieurdv
						));
							
							echo '<script language="Javascript">
							<!--
							document.location.replace("index.php");
							// -->
							</script>';
							
					?> 
							<!--<h3 class="h3_event_cree"> EVENEMENT CRÉÉ ! </h3> -->
			
			
		<?php	
					
					
					
				
		} //end if(!empty($_POST['blablabla']))
		} // end if(isset($_POST['blablabla'])
		
		else {
		?> <h2> CREER UN EVENEMENT </h2> <?php } ?>
		
<form method="post" id="customForm" action="creer_event.php">
<div class="creer_event_left">
			<div>
				<label for="etitle">Titre:</label>
				<input id="etitle" name="etitle" type="text" />
			</div>
			<div>
				<label for="sport">Sport:</label>
				<select name="sport" id="sport">
					   <option name="sport" id="sportoption"><?php if (!empty($_POST)){ echo $_POST['sport']; }?></option>
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
			<div>
				<label for="qdate">Date:</label>
				<input id="qdate" name="qdate" type="text" <?php if (!empty($_POST)){ ?> value="<?php echo $_POST['qdate']; ?>" <?php } ?>/>
			</div>
			<div>
				  <label for="qtime">Heure:</label>
				   <select name="hours" id="hours">
					   <option name="hours"></option>
						<?php for ($i = 1; $i <= 24; $i++) : ?>
						<option value="<?php echo sprintf('%02d', $i); ?>"><?php echo sprintf('%02d', $i); ?></option>
						 <?php endfor; ?>
				   </select><label>H</label>
				   <select name="minutes" id="minutes">
					   <option name="minutes"></option>
						<?php for ($i = 0; $i <= 59; $i++) : ?>
						<option value="<?php echo sprintf('%02d', $i); ?>"><?php echo sprintf('%02d', $i); ?></option>
						 <?php endfor; ?>
				   </select><label>min</label>
			</div>
			<div>
				<label for="participants">Participants:</label>
				<select name="participants" id="participants">
					   <option name="participants"><?php if (!empty($_POST)){ echo $_POST['participants']; }?></option>
						<?php for ($i = 1; $i <= 40; $i++) : ?>
						<option><?php echo $i; ?></option>
						 <?php endfor; ?>
				   </select>
			</div>
</div>
<div class="creer_event_right">
			<div>
				<div class="description"><label for="description">Description:</label></div>
				<textarea name="description" id="description" cols="40" rows="5"></textarea>
			</div>
			
			<div>
				<label for="lieurdv">Lieu du rendez-vous:</label>
				<input id="lieurdv" name="lieurdv" type="text" size="40">
			</div>
			<div>
				<label for="lieu">Lieu:</label>
				<input id="searchTextField" name="lieu" type="text" size="50">
			</div>
			<div id="map_canvas"></div>

			<div>
				<input id="send" name="send" type="submit" value="Créer" />
			</div>
</div>
		</form>
	</div> <!-- #creer_event -->
	<?php } // if !empty user 
	?>
	
	
	
	<div class="clear"></div>
	
	
			<div id="footer">
				<?php include "templates/footer.php" ; ?>
			</div>
		</div>


</body>
</html>
