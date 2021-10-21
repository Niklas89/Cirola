<?php
session_start();
?>
<h1>Détails de l'event</h1> <?php

		  try{
		  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
		  $bdd->exec('SET NAMES utf8');
		  
		  $reponse = $bdd->query('SELECT etitle,ename,id FROM event ORDER BY id DESC');
		while ($row = $reponse->fetch())
		{
			echo '- <a href="voir_event.php?id='.$row['id'].'">'.$row['etitle'].'</a>: organisé par <strong>'.$row['ename'].'</strong><br />'; 
		}
		$reponse->closeCursor();
		  
		  }
		  
		  catch(Exeption $e){
		  die('Erreur:'.$e->getMessage());
		  }
?>
<p>&larr; <a href="profil.php">Retour au profil</a></p>