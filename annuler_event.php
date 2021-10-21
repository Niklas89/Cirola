<?php
session_start();
include 'function/verification_session.php';

		try{
		  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
		  $bdd->exec('SET NAMES utf8');



		if(isset($_POST['id'])){
					$userid =  $_SESSION['id'];
					$req = $bdd->query("DELETE FROM users_has_event WHERE fk_event =".$_POST['id']);
					$req = $bdd->query("DELETE FROM event WHERE id =".$_POST['id']);
					  header('Location: index.php');
		}
		
		$reponse->closeCursor();
		  
		  }
		  
		  catch(Exeption $e){
		  die('Erreur:'.$e->getMessage());
		  } ?>





?>