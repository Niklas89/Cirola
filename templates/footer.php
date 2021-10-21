<?php
				try{
				  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
				  $bdd->exec('SET NAMES utf8');
				  }
				  
				  catch(Exeption $e){
				  die('Erreur:'.$e->getMessage());
				  }
				  
				 $req = $bdd->prepare('SELECT * FROM publicite');
				 $req->execute(array());
				 $data = $req->fetch();
				 $dir = 'publicite/';
				 $req->closeCursor();
?>

			<div class="separation"></div>
			
			<div class="publicite">
				<?php
								 echo "<a href='".$data['lien']."'><img src='".$dir.$data['img']."'/></a>";
				?>
			</div>
			
			
			<div class="social">
				<h3>Suivez - nous</h3>
				<a href="http://www.facebook.com/pages/Cirola/436103889738181" title="Facebook"><img src="templates/images/facebook.png" class="facebook" alt="facebook" /></a>
				<a href="https://twitter.com/#!/CirolaCom" title="Twitter"><img src="templates/images/twitter.png" alt="twitter" /></a>
			</div>
			
			<p>Copyright © 2012 Cirola - All Rights Reserved</p>
			
		