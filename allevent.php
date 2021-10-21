<?php
session_start();

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="author" content="Niklas" />
	<meta name="contact" content="" />

	<title> Recherche | Cirola.com </title>
	
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
					  
					  $req = $bdd->query("SELECT * FROM event");
					while ($data = $req->fetch(PDO::FETCH_OBJ))
					{
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
					$req->closeCursor();
					  
					  }
					  
					  catch(Exeption $e){
					  die('Erreur:'.$e->getMessage());
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
	