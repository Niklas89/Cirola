<div id="welcome">
	
	<h2> BIENVENUE <span class="sous_h2"> CHEZ CIROLA </h2>
<?php
						 try{
						  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
						  $bdd->exec('SET NAMES utf8');
							$reponse = $bdd->query('SELECT message FROM message_home WHERE id=1');
							while ($data = $reponse->fetch()){
								echo '<p>';
							     echo $data['message']; 
								 echo '</p>';
							}
							$reponse->closeCursor();
						}
							catch(Exeption $e){
							die('Erreur:'.$e->getMessage()); } 

?>
	
	
	
</div>

<div id="inscrit">

	<h2> PAS ENCORE INSCRIT ? </h2>
	
	<p> Inscrit toi gratuitement et rejoins immédiatement n’importe quel évènement ! </p>
	
	<a href="inscription.php" title="Inscription à Cirola"> Je m'inscris gratuitement ! </a>
	
</div>

<div class="clear"></div>


<div id="presentation">
	
	<div class="bloc_presentation">
		<p class="chiffre"> 1 </p>
		<img src="templates/images/jeminscris.png" alt="Inscription" />
		<h3> Je m'inscris </h3>
	</div>
	
	
	<div class="bloc_presentation">
		<p class="chiffre"> 2 </p>
		<img src="templates/images/jeparticipe.png" alt="Participation" />
		<h3> Je participe </h3>
	
	</div>
	
	<div class="bloc_presentation" id="ajustement">
		<p class="chiffre"> 3</p>
		<img src="templates/images/jenote.png" alt="Participation" />
		<h3> Je note </h3>
	</div>

</div>

<div class="clear"></div>