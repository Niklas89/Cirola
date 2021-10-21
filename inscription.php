<?php
session_start();
if(!empty($_SESSION['users']))
{
  header('Location: index.php');
}

if(!empty($_POST))
{
  extract($_POST);
  $valid = true;
  
  try{ //Connection à la base de donnée
  $bdd = new PDO('mysql:host=localhost;dbname=cirolaprod', 'root', 'root') or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES utf8');
  }
  
  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  }
  
  
  $req = $bdd->prepare('SELECT id FROM users WHERE login=:nom');
  $req->execute(array('nom'=>$nom));
  if($req->rowCount()>0)
  {
    $valid = false;
    $erreurid = 'Ce pseudo est déjà pris';
  }
  
  $req = $bdd->prepare('SELECT id FROM users WHERE email=:email');
  $req->execute(array('email'=>$email));
  if($req->rowCount()>0)
  {
    $valid = false;
    $erreurid = 'Cette adresse e-mail est déjà utilisée par un membre';
  }
  $req->closeCursor(); //Ne pas oublier de fermer la requete une fois que c'est fini
  
  if($valid)
  {
    $hash = md5(rand(0,1000)); //genere le hash pour le lien d'activation
    
    $to = $email;
    $subject = 'Inscription|Validation';
    $message = 'Merci pour votre inscription sur SportBook!<br />
    Vous pourrez vous connecter sur le site après avoir cliqué sur le lien d\'activation ci-dessous.<br />
    Voici vos identifiants, nous vous recommandons de changer le mot de passe.<br />
    Login : '.$nom.'<br />
    Mot de passe : '.$pass.'<br />
    Cliquez sur le lien suivant pour activer votre compte<br />
    <a href="http://cirola.com/verif.php?email='.$email.'&hash='.$hash.'">http://cirola.com/Sportbook/verif.php?email='.$email.'&hash='.$hash.'</a>';
    
    $headers = 'From:noreply@cirola.com'."\r\n";
    $headers.='MIME-version: 1.0'."\r\n";
    $headers.='Content-type: text/html; charset=utf-8'."\r\n";
    mail($to,$subject,$message,$headers); 
    
    $req = $bdd->prepare('INSERT INTO users (login,pass,email,lname,fname,city,postal,tel, hash) VALUES (:nom,:pass,:email,:lname,:fname,:city,:postal,:tel, :hash)');
    $req->execute(array(
	  'nom'=>$nom,	
      'pass'=>sha1($pass),
      'email'=>$email,
	  'lname'=>$lname,
	  'fname'=>$fname,
	  'city'=>$city,
	  'postal'=>$postal,
	  'tel'=>$tel,
	  'hash'=>$hash
    ));
    
    $req->closeCursor();
    $ok = 'Votre inscription a été prise en compte, afin d\'activer votre compte et participer à Cirola, veuillez consulter votre boite mail. <br />
			Revenir à <a href="index.php" title="Accueil de Cirola"> l\'Accueil </a>';
	unset($nom);
    unset($email);
	unset($lname);
	unset($fname);
	unset($city);
	unset($tel);
	unset($postal);
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

	<title> Inscription | Cirola.com </title>
	
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
	
	<script src="lib/jquery.js" type="text/javascript"></script>
	<script src="lib/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript">
			$.validator.setDefaults({
				submitHandler: function() {  $(form).submit(); }
			});

			$().ready(function() {
				$("#commentForm").validate();

				// Validation quand on tab ou quand on envoie
				$("#signupForm").validate({
					rules: {
						nom: {
							required: true
						},
						lname: {
							required: true
						},
						fname: {
							required: true
						},
						pass: {
							required: true,
							minlength: 5
						},
						confirm_password: {
							required: true,
							minlength: 5,
							equalTo: "#pass"
						},
						email: {
							required: true,
							email: true
						},
						city: {
							required: true
						},
						postal: {
							required: true,
							number:true
						},
						tel: {
							required: true,
							number:true
						},
						condition : {
							required: true
						}
						
					},
					messages: {
						nom: {
							required: "Entrez un login s'il vous plaît",
						},
						lname: {
							required: "Entrez votre nom s'il vous plaît",
						},
						fname: {
							required: "Entrez votre prénom s'il vous plaît",
						},
						pass: {
							required: "Entrez un mot de passe s'il vous plaît",
							minlength: "Votre mot de passe doit avoir au moins 5 caractères"
						},
						confirm_password: {
							required: "Entrez un mot de passe s'il vous plaît",
							minlength: "Votre mot de passe doit comporter au moins 5 caractères",
							equalTo: "Entrez le même mot de passe s'il vous plaît"
						},
						city: {
							required: "Entrez votre ville s'il vous plaît"
						},
						postal: {
							required: "Entrez votre code postal s'il vous plaît",
							number: "Ceci n'est pas un code postal"
						},
						condition: {
							required: "Veuillez accepter les conditions générales s'il vous plaît"
						},
						tel: {
							required: "Entrez votre numéro de téléphone s'il vous plaît",
							number:"Entrez vos 10 chiffres de votre numéro, merci"
							
						},
						email: "Entrez une adresse mail valide s'il vous plaît"
						
					}
				});
			});
			</script>
		
		<!-- Popup Inscription -->
		
		
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
				$('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend(); 
				
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
		
		</div> <!-- End header -->
		
		<div id="conteneur_body">
			
			<div id="inscription_formulaire">
				<?php if(isset($erreurid)) echo '<div class="erreurid">'.$erreurid.'</div>';?>
				<?php if(isset($ok)) echo '<div class="ok">'.$ok.'</div>';?>
			
				<h3>INSCRIPTION</h3>
				
				<p> Créez vos identifiants </p>
				
				<form id="signupForm" action="inscription.php" method="post">
				  
					<div class="bloc_formulaire_inscription">
					  <label for="nom">Login * :</label> <!-- Login de connection -->
					  <input class="icon_login" type="text" name="nom" value="<?php if(isset($nom)) echo $nom;?>" />
					</div>
					
					<div class="bloc_formulaire_inscription2">  
					  <label for="lname">Nom * :</label> <!-- Nom -->
					  <input class="icon_personne" type="text" name="lname" value="<?php if(isset($lname)) echo $lname;?>" />
					</div>
					
					
					
					<div class="bloc_formulaire_inscription">
					   <label for="pass">Mot de passe * :</label> <!-- Password -->
					   <input class="icon_mdp" id="pass" name="pass" type="password" />
					</div>
				
					<div class="bloc_formulaire_inscription2">
					  <label for="fname">Prénom * :</label> <!-- Prenom  -->
					  <input class="icon_personne" type="text" name="fname" value="<?php if(isset($fname)) echo $fname;?>" />
					</div>
					
					
				
					<div class="bloc_formulaire_inscription">
					  <label for="confirm_password">A Confirmer * :</label> <!-- Confirm Password -->
					  <input class="icon_mdp" id="confirm_password" name="confirm_password" type="password" />
					</div> 
				 
					<div class="bloc_formulaire_inscription2">  
					  <label for="tel">Télephone * :</label> <!-- Telephone  -->
					   <input class="icon_tel" type="text" name="tel" value="<?php if(isset($tel)) echo $tel;?>" />
					</div>
				
					  
					<div class="bloc_formulaire_inscription">
					  <label for="email">Votre E-mail * :</label> <!-- Email -->
					  <input class="icon_personne" type="text" name="email" value="<?php if(isset($email)) echo $email;?>" />
					</div>
				
					<div class="bloc_formulaire_inscription2">  
					  <label for="city">Ville * :</label> <!-- Ville  -->
					  <input class="icon_ville" type="text" name="city" value="<?php if(isset($city)) echo $city;?>" />
					</div>
					
					
					<div class="bloc_formulaire_inscription">
					</div>
				
					<div class="bloc_formulaire_inscription2">
					   <label for="postal">Code Postal * :</label> <!-- Postal  -->
					  <input class="icon_ville" type="text" name="postal" value="<?php if(isset($postal)) echo $postal;?>" />
					</div>
					
					<div class="bloc_formulaire_inscription">
					</div>
					
					<div class="bloc_formulaire_inscription2">
						<a href="#?w=500" rel="popup_01" class="poplight" title="Pourquoi dois-je fournir ces informations?">Pourquoi dois-je fournir ces informations? </a>
					</div>
					
					<div id="popup_01" class="popup_block">
						<h2>Pourquoi dois-je fournir ces informations ?</h2>
						<p>Lorsque les conditions nécessaires à l'inscription sont remplies, chaque Membre dispose
							d'un identifiant (nom d’utilisateur ou login) et d'un mot de passe. Ces éléments sont
							strictement personnels et confidentiels et ne devront pas être communiqués ni partagés avec
							des tiers. <br /> <br />

							Dans le cas où un Membre diffuserait ou utiliserait ces éléments de façon contraire à leur
							destination, Cirola se réserve le droit de résilier le compte du Membre sans préavis. <br /><br />
							
							LE MEMBRE SERA SEUL RESPONSABLE DE L'UTILISATION DE CES ELEMENTS
							D'IDENTIFICATION PAR DES TIERS OU DES ACTIONS OU DECLARATIONS FAITES
							PAR L'INTERMEDIAIRE DE SON COMPTE PERSONNEL DE MEMBRE, QU'ELLES
							SOIENT FRAUDULEUSES OU NON. IL GARANTIT Cirola CONTRE TOUTE DEMANDE A
							CE TITRE. PAR AILLEURS, Cirola NE DISPOSANT PAS DES MOYENS DE VERIFIER
							L'IDENTITE DES PERSONNES S'INSCRIVANT A SES SERVICES, Cirola N'EST PAS
							RESPONSABLE EN CAS D'USURPATION DE L'IDENTITE D'UN MEMBRE. <br /><br />
							
							Si le Membre a des raisons de penser qu'une personne utilise ses éléments d'identification
							ou son compte, il devra en informer immédiatement Cirola. <br /><br />
							
							Dans le cas d'un conflit avec un ou plusieurs autres Membres, Cirola ne sera pas tenu
							responsable des dommages dans le présent ou le futur, de quelque manière que ce soit, qui
							seraient le résultat d'un conflit. <br /><br />
							
							Cirola se réserve le droit de désactiver les comptes des Membres qui n'ont pas utilisé le
							service durant une période supérieure ou égale à 1 an. La date de fin d'utilisation du service
							prise en compte pour le calcul de la durée de la période se définit de la manière suivante : la
							date de la dernière connexion valide aux services Cirola. <br /><br />
							
							<strong> Contenu de vos données personnelles : </strong> <br /><br />
							
							Cirola se réserve le droit de rejeter tout ou partie, dont le texte : <br /><br />
							
							utilise un vocabulaire et/ou un pseudo vulgaire ou obscène, constitue une atteinte aux
							bonnes moeurs, une infraction à la législation en vigueur porte des propos diffamatoires,
							racistes, homophobes, xénophobes, zoophiles, pédophiles, ou à vocation commerciale, et
							d’une manière générale tout écrit contraire à l’esprit du site Cirola. <br /><br />
							
							Il en va de même concernant la publication de visuels; pourront être rejetée les publication :
							à caractère obscène, constituant une atteinte aux bonnes moeurs, une infraction à la
							législation en vigueur, de caractère racistes, homophobes, xénophobes, zoophiles,
							pédophiles, ou à vocation commerciale, montrant les coordonnées de la personne, contraire
							à l'esprit du site Cirola. <br /><br />
							
							Vous reconnaissez que Cirola peut visionner le contenu avant et pendant sa diffusion. Vous
							reconnaissez et acceptez que si Cirola protège le contenu, Cirola peut être amené à le
							divulguer pour se conformer aux lois en vigueur ou si de bonne foi, Cirola pense qu'une telle
							mesure est nécessaire dans le cadre d'une procédure judiciaire: pour faire respecter les
							conditions d'utilisation, pour répondre à des plaintes arguant de la violation des droits de
							tiers, pour protéger les droits ou les intérêts de Cirola, ses utilisateurs ou le public. <br /><br />
							
							<strong>Engagement des utilisateurs de Cirola : </strong> <br /><br />
							
							Une fois inscrit, le Membre bénéficiera d'un accès aux services disponibles sur Cirola. <br /><br />
							
							Dans le cadre de l'utilisation des services, le Membre s'engage notamment à respecter les
							règles suivantes : <br /><br />
							"se conformer aux lois en vigueur et respecter les droits des tiers ; <br />
							ne pas utiliser Cirola à des fins professionnelles ou commerciales ou idéologiques : <br />
							prospection, racolage, prostitution, propagande...;<br />
							ne poster, n'indiquer ou ne diffuser sous quelle que forme que ce soit des informations ou
							contenus non conformes à la réalité ;<br />
							ne pas tenir des propos, ni diffuser, sous quelle que forme que ce soit, des contenus
							contrevenant aux droits d'autrui ou à caractère diffamatoire, injurieux, obscène, pédophile,
							homophobe, xénophobe, zoophile, violent ou incitant à la violence ;<br />
							ne pas poster, indiquer ni diffuser sous quelle que forme que ce soit des informations ou
							contenus ayant pour effet de diminuer, de désorganiser, d'empêcher l'utilisation normale des
							Services, d'interrompre et/ou de ralentir la circulation normale des communications entre les
							Membres par l'intermédiaire des Services, tels que des logiciels, virus, bombes logiques,
							envoi massif de messages ... Cirola se réserve le droit de supprimer les messages qui sont
							envoyés massivement par un Membre afin de préserver une qualité d'utilisation normale du
							service auprès des autres Membres "; <br /><br />
							
							ATTENTION : TOUTE TENTATIVE CONSISTANT A ENDOMMAGER DELIBEREMENT UN
							SITE WEB REPRESENTE UNE INFRACTION AU DROIT PENAL ET AU DROIT CIVIL. SI
							LE CAS VENAIT A SE PRODUIRE, Cirola DISQUALIFIERAIT LE CONTREVENANT ET SE
							RESERVERAIT LE DROIT DE LE POURSUIVRE EN DOMMAGES-INTERETS DANS LES
							LIMITES MAXIMALES PERMISES PAR LA LOI. <br /><br />
							
							Ne pas poster, indiquer ni diffuser sous quelque forme que ce soit des informations ou
							contenus intégrant des liens vers des sites tiers qui auraient un caractère illégal, contraires
							aux bonnes moeurs et/ou non conformes à l'objet de Cirola. Cirola NE PEUT ETRE TENU
							POUR RESPONSABLE DES FAUSSES DECLARATIONS FAITES PAR UN MEMBRE. IL
							EST DONC IMPORTANT DE PRENDRE CERTAINES PRECAUTIONS LORS DE
							RENCONTRES AVEC UN AUTRE. <br /><br />
							
							Cirola SE DEGAGE DE TOUTE RESPONSABILITE LORS DE RENCONTRES ENTRE SES
							MEMBRES, SUR LE SITE OU A L'EXTERIEUR DU SITE.<br /><br />
							
							Cirola rappelle à ses Membres qu'il leur est interdit d'indiquer ou de divulguer toute
							information personnelle (nom de famille, adresse postale et/ou électronique, téléphone, etc.)
							permettant d’identifier un Membre tiers de Cirola sur le site. Cirola ne peut être tenu pour
							responsable des contenus diffusés par un Membre susceptibles de contrevenir aux droits
							d'un ou plusieurs autres Membres ou des tiers. <br /><br />
							
							<strong>Vie privée et protection des données du Membre :</strong> <br /><br />
							
							Cirola respecte les normes les plus strictes de protection de la vie privée et des données
							personnelles. <br /><br /> 
							
							Certaines informations, indications ou contenus, photographies ou vidéos, que les Membres
							peuvent fournir à titre facultatif sont susceptibles, sous la responsabilité du Membre
							concerné, de révéler l'origine ethnique du Membre, sa nationalité et/ou ses préférences
							relationnelles. En fournissant de telles informations, toutes facultatives, le Membre concerné
							consent dès lors expressément au traitement de ces données dites " personnelles " par
							Cirola.<br />
							Les droits et garanties des Membres de Cirola respectent notamment la loi "informatique et
							libertés" n° 78-17 du 6 janvier 1978 et la loi sur la "confiance dans l'économie numérique " n°
							2004-575 du 21 juin 2004 (article L. 33-4-1 modifié du code des postes et
							télécommunications et article L. 121-20-5 nouveau du code de la consommation).<br /><br />
							
							
							<strong>Tarifs : </strong><br /><br />
							
							L'inscription à Cirola est gratuite. Le membre est libre de résilier son inscription à tout
							moment si les nouveaux termes du contrat ne lui convenaient pas. <br /><br />
							
							
							<strong>Droits d’auteur et droits afférents</strong><br /><br />
							
							L’ensemble des éléments constituants www.Cirola.com, à savoir les textes, les marques, les
							logos, les graphismes, les animations, les photographies, les vidéos, les bases de données,
							les créations et oeuvres diverses, ainsi que le site lui-même, relève des législations
							françaises et internationales sur les droits d’auteurs et les droits voisins du droit d’auteur.
							Ces éléments sont la propriété intellectuelle et exclusive de la société Cirola, hormis les
							éléments réalisés par les prestataires extérieurs àwww.Cirola.com n’ayant pas cédé leurs
							droits d’auteur. <br /><br />
							
							Toute représentation ou reproduction intégrale ou partielle, sans l’autorisation expresse de la
							société Cirola, est interdite, sous peine de poursuites judiciaires. Il en est de même pour la
							traduction, l’adaptation ou la transformation, l’arrangement ou la reproduction par une
							technique ou un procédé quelconque. <br /><br />
							
							<strong>Droit du producteur de la base de données </strong><br /><br />
							
							La société Cirola est le producteur de la base de données constituée par le site Cirola. Toute
							extraction ou utilisation du contenu de la base non expressément autorisée peut engager la
							responsabilité civile et/ou pénale de son auteur. La société Cirola se réserve la possibilité
							d’exercer toutes voies de droit à l’encontre des personnes qui n’auraient pas respecté cette
							interdiction. <br /><br />
							
							<strong>Droit de marque</strong> <br /><br />
							
							Les dénominations et les logotypes sont des marques déposées, propriétés de la société
							OneWeb A.E.. Toute utilisation non expressément autorisée peut engager la responsabilité
							civile et/ou pénale de son auteur. La société Cirola se réserve la possibilité d’exercer toutes
							voies de droit à l’encontre des personnes qui porteraient atteinte à ses droits. <br /><br />
							
							<strong>Droits d’utilisation</strong> <br /><br />
							
							Les droits d'utilisation concédés par Cirola au Membre sont strictement limités à l'accès, au
							téléchargement, à l'impression, à la reproduction sur tous supports et à l'utilisation de ces
							documents pour un usage privé et personnel dans le cadre et pour la durée de l'adhésion à
							Cirola. Toute autre utilisation par le Membre est interdite sans l'autorisation de Cirola.
							Le Membre s'interdit notamment de modifier, copier, reproduire, télécharger, diffuser,
							transmettre, exploiter commercialement et/ou distribuer de quelque façon que ce soit les
							services, les pages du site Cirola, ou les codes informatiques des éléments composant les
							services et le site Cirola. <br /><br />
							
							<strong>Résiliation : </strong><br /><br />
							Chaque Membre peut résilier son inscription à Cirola à tout moment et sans motif. <br /><br />
							
							En cas de manquement par le Membre aux présentes conditions d'utilisation, Cirola se
							réserve le droit de suspendre ou de résilier le compte du Membre sans préavis et/ou
							d'engager des poursuites à son encontre.<br /><br />
							
							Cette résiliation interviendra de plein droit et sans préjudice de tous les dommages et
							intérêts qui pourraient être réclamés par Cirola au Membre ou à ses ayants droits et
							représentants légaux en réparation du préjudice subi du fait de tels manquements. <br /><br />
							
							Le Membre sera informé par courrier électronique de la résiliation ou de la confirmation de la
							résiliation de son compte. Les données relatives au Membre seront détruites à sa demande
							ou à l'expiration du délai légal à compter de la résiliation du compte du Membre. <br /><br />
							
							<strong>Responsabilité et garantie :</strong> <br /><br />
							
							Informations et contenus fournis par les Membres <br />
							Les informations fournies par un Membre à Cirola doivent être exactes et conformes à la
							réalité. Les conséquences de leur divulgation sur sa vie et/ou celle des autres Membres sont
							de la responsabilité exclusive du Membre concerné. Le Membre renonce à tout recours à
							l'encontre de Cirola, notamment sur le fondement de l'atteinte éventuelle à son droit à
							l'image, à son honneur, à sa réputation, à l'intimité de sa vie privée, résultant de la diffusion
							ou de la divulgation d'informations le concernant dans les conditions prévues par les
							présentes. <br /><br />
							
							Dans le cas où la responsabilité de Cirola serait recherchée à raison d'un manquement par
							un Membre aux obligations qui lui incombent aux termes de la loi ou de ces conditions
							d'utilisation, ce dernier s'engage à garantir Cirola contre toute condamnation prononcée à
							son encontre, cette garantie couvrant tant les amendes et indemnités qui seraient
							éventuellement versées, que les honoraires d'avocat et frais de justice qui pourraient être
							mis à sa charge.<br /><br />
							
							<strong>Fonctionnement du site Cirola et des services</strong><br />
							Le Membre doit posséder un équipement des logiciels et des paramétrages nécessaires au
							bon fonctionnement de Cirola : Navigateur IE7, Firefox ou équivalent, ...
							Cirola ne garantit pas que les services seront utilisables si l'abonné utilise un utilitaire de
							« pop-ups killer », dans ce cas, Cette fonction devra être désactivée préalablement à
							l'utilisation du service Cirola.<br /><br />
							
							En outre, le Membre doit disposer des compétences, des matériels et des logiciels requis
							pour l'utilisation d'Internet, ou le cas échéant, de services Internet, téléphoniques et
							reconnaît que les caractéristiques et les contraintes d'Internet ne permettent pas de garantir
							la sécurité, la disponibilité et l'intégrité des transmissions de données sur Internet. <br /><br />
							
							Dans ces conditions, Cirola ne garantit pas que les services fonctionneront sans interruption
							ni erreur de fonctionnement. En particulier, leur exploitation pourra être momentanément
							interrompue pour cause de maintenance, de mises à jour ou d'améliorations techniques, ou
							pour en faire évoluer le contenu et/ou leur présentation. Dans la mesure du possible, Cirola
							informera ses Membres préalablement à une opération de maintenance ou de mise à jour.
							Le Membre renonce à rechercher la responsabilité de Cirola au titre du fonctionnement et de
							l'exploitation des Services. <br /><br />
							
							De même, Cirola ne saurait également être tenue responsable d'un non fonctionnement,
							d'une impossibilité d'accès, ou de mauvaises conditions d'utilisation du site Cirola imputables
							à un équipement non adapté, à des dysfonctionnements internes au fournisseur d'accès du
							Membre, à l'encombrement du réseau Internet, et pour toutes autres raisons extérieures à
							Cirola. <br /><br />
							
							<strong>Liens</strong> <br />
							Le site Cirola peut inclure des liens hypertextes vers d'autres sites Web extérieurs ou vers
							d'autres sources Internet. Dans la mesure où Cirola ne peut contrôler ces sites et ces
							sources externes, il ne peut être tenu pour responsable de la mise à disposition de ces sites
							et sources externes, et ne peut supporter aucune responsabilité quant à leur contenu,
							publicités, produits, services ou tout autre élément disponible sur ou à partir de ces sites ou
							sources externes. Toute difficulté relative à un lien doit être soumise à l'administrateur ou au
							webmaster du site concerné. Il est rappelé que la consultation et/ou l'utilisation de ces sites
							et sources externes sont régies par leurs propres conditions d'utilisation. Nous vous
							encourageons fortement à vérifier les politiques de sécurité et de confidentialité de ces sites
							avant toute transaction avec eux.
							Enfin, si dans le cadre d'une recherche conduite sur le site Cirola, le résultat de celle-ci
							amenait le Membre à pointer sur des sites, des pages ou des forums dont le titre et/ou les
							contenus constituent une violation du droit français, le Membre est invité à interrompre sa
							consultation du site concerné au risque de voir sa responsabilité engagée, celle de Cirola
							étant exclue. <br /><br />
							
							<strong>Alertes :</strong> <br />
							Cirola s'efforce de veiller au respect des principes précédemment énoncés. Eu égard à
							l'ampleur des échanges opérés sur le site, le risque de leur violation ne peut être écarté. Si
							vous étiez témoin du non-respect des engagements visés ci-dessus, merci d'en informer
							Cirola qui agira dans le respect de votre anonymat. <br /><br />
							<strong>Limitation de responsabilité :</strong><br />
							La responsabilité globale de Cirola est limitée au cadre de la prestation faisant l'objet d'un
							manquement. <br /><br />
							<strong>Convention entre le membre et Cirola :</strong><br />
							Ces conditions d'utilisation, ainsi que les pages du site Cirola auxquelles il est fait référence
							dans les présentes, constituent un contrat régissant les relations entre le Membre et Cirola.
							Modifications de Cirola ou des conditions générales d'utilisation : Cirola se réserve le droit de
							modifier ou de faire évoluer à tout moment les pages du site Cirola ou les conditions
							d'utilisation qui leur sont applicables. Ces modifications entreront en vigueur dès leur mise en
							ligne sur le site.<br /><br />
							Les Membres sont donc invités à consulter la version constamment en ligne sur le site. La
							présence du Membre sur le site implique sa pleine acceptation de toute révision ou
							modification.<br /><br />
							<strong>Droit applicable - attribution de juridiction :</strong><br />
							Ces conditions d'utilisation sont régies, interprétées et appliquées conformément au droit
							français. Les tribunaux de Bobigny seront seuls compétents pour connaître de tout litige
							relatif aux présentes, y compris, sans que cette énumération soit limitative, leur validité, leur
							interprétation, leur exécution et/ou leur résiliation et ses conséquences.
.</p>
					</div>
					
					<div class="clear"></div>
					
					<div id="checbox_inscription">
						Accepter les conditions générales <input type="checkbox" name="condition" value="condition" /> 
					</div>
					
					<div id="bouton_inscription">
						<a href="index.php" title="Accueil de Cirola"> Accueil </a>
						<input type="submit" class="submit_button" value="Inscription" />
					</div>
					<div class="clear"></div>
				</form>
				
			</div>
			
			<div id="footer">
				<?php include "templates/footer.php" ; ?>
			</div>
		</div>
	</div>
</body>

</html>