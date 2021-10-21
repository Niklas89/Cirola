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

	<title> SportBook </title>
	
	<link rel="stylesheet" type="text/css" href="templates/css/style.css" />
		<script src="js/jquery-1.7.1.js"></script>
		<script src="js/jquery.ui.core.js"></script>
		<script src="js/jquery.ui.widget.js"></script>
		<script src="js/jquery.ui.datepicker.js"></script>
	

		
	
	
	
	
</head>

<body>


	<div id="conteneur">
	
		<?php include "templates/logo.html" ; ?>
	
		<div id="header"> <!-- Header -->
	
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
						
						<input type="submit" class="submit_button" value="Log In" />
				</form>
				<?php
					}
					else{
				?>
						<h2><span class="orange"> <?php echo $_SESSION['users'];?> </span></h2>
						<p> <a href="logout.php"> Déconnection </a> </p>
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
<p>Nous sommes désolé mais cette fonctionnalité n'est pas encore disponible pour le moment, le site est en version beta et continue d'être développé.</p>
<p>L'équipe Cirola.</p>
			</div>
			
			<div class="clear"></div>
			
			<div id="footer">
				<?php include "templates/footer.php" ; ?>
			</div>
		</div>
	</div>
		
	




</body>

</html>
	