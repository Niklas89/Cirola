-- phpMyAdmin SQL Dump
-- version OVH
-- http://www.phpmyadmin.net
--
-- Host: mysql51-56.perso
-- Generation Time: Jul 06, 2012 at 08:29 AM
-- Server version: 5.1.49
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cirolaprod`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `etitle` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `ename` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `edate` datetime NOT NULL,
  `qdate` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `qtime` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `lieu` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `sport` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci NOT NULL,
  `participants` int(100) NOT NULL,
  `orga` tinyint(1) NOT NULL,
  `fini` tinyint(1) NOT NULL,
  `lieurdv` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `eid` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=97 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `etitle`, `ename`, `edate`, `qdate`, `qtime`, `lieu`, `sport`, `description`, `participants`, `orga`, `fini`, `lieurdv`, `eid`) VALUES
(49, 'lu', 'kev', '2012-04-11 00:00:00', '04/03/2012', '05h25', 'Poissy', 'Football', 'Ballblalblal', 55, 1, 0, '', ''),
(50, 'Partie du basket', 'niklas', '2012-04-20 10:39:58', '04/13/2012', '21h58', 'Levallois-Perret, France', 'Football', 'Une petite partie de foot à 5.', 5, 1, 0, '', ''),
(48, 'Lol', 'Bertrand', '2012-04-19 00:00:00', '04/03/2012', '05h25', 'Auber', 'Rugby', 'Blablalbla', 30, 1, 0, '', ''),
(46, 'Lol', 'Bertrand', '2012-04-19 00:00:00', '04/03/2012', '05h25', 'Auber', 'Rugby', 'Blablalbla', 30, 1, 0, '', ''),
(47, 'lu', 'kev', '2012-04-11 00:00:00', '04/03/2012', '05h25', 'Poissy', 'Football', 'Ballblalblal', 55, 1, 0, '', ''),
(45, 'loul', 'kevin78', '2012-04-16 23:15:09', '04/07/2012', '04h01', 'Aubervilliers, France', 'Football', 'dqdzqdq', 39, 1, 0, '', ''),
(44, 'lu', 'kev', '2012-04-11 00:00:00', '04/03/2012', '05h25', 'aubergenville', 'Rugby', 'Grand tournoi !', 25, 1, 0, '', ''),
(43, 'lala', 'niklas', '2012-04-09 14:37:08', '04/05/2012', '03h07', 'Tour Eiffel, Paris, France', 'Rugby', 'sadsadsad', 13, 1, 0, '', ''),
(42, 'safdad', 'niklas', '2012-04-08 09:17:01', '04/11/2012', '06h06', 'Arcueil, France', 'Football', 'aadsad', 2, 1, 0, '', ''),
(51, 'Partie du basket', 'niklas', '2012-04-20 10:42:54', '04/13/2012', '21h58', 'Levallois-Perret, France', 'Basketball', 'Une petite partie de basket a 5.', 5, 1, 0, '', ''),
(66, 'Test', 'Duplo', '2012-04-25 13:40:19', '06/12/2012', '01h01', 'Stade de France, Saint-Denis, France', 'Running', 'lifhsof', 22, 1, 0, '', ''),
(64, 'asdcda', 'niklas', '2012-04-24 16:29:51', '04/18/2012', '01h01', 'Association Emmaüs, Paris, France', 'Running', 'asdasdadd', 18, 1, 0, '', ''),
(61, 'eventtest', 'niklas', '2012-04-24 14:15:39', '04/11/2012', '03h06', 'Saint-Denis, France', 'Tennis', 'description de levent', 4, 1, 0, '', ''),
(65, 'FootballParty', 'kevin78', '2012-04-24 22:52:10', '04/11/2012', '20h30', 'Aubergenville, France', 'Running', 'Un petit tournoi de sport en salle.', 1, 1, 0, '', ''),
(67, 'blablabla', 'niklas', '2012-04-27 10:03:28', '04/12/2012', '04h04', 'DS MEDIA, Avenue du Maine, Paris, France', 'Tennis', 'asda sajdlikjdsa dsa jlsaijsa o', 12, 1, 0, 'sadjlas jdlsada', ''),
(68, 'blablabla', 'niklas', '2012-04-27 10:04:40', '04/12/2012', '04h04', 'DS MEDIA, Avenue du Maine, Paris, France', 'Tennis', 'asda sajdlikjdsa dsa jlsaijsa o', 12, 1, 0, 'sadjlas jdlsada', ''),
(71, 'Football0325', 'kevin78', '2012-05-09 23:49:29', '05/23/2012', '03h02', 'Aubervilliers, France', 'Football', 'Un foot en salle la nuit !', 7, 1, 0, 'aubergenville', ''),
(72, 'Foot03', 'kevin78', '2012-05-10 01:50:30', '05/23/2012', '03h05', 'Stade de France, Saint-Denis, France', 'Football', 'Deuxième partie', 7, 1, 0, 'Stade de France', ''),
(73, 'Ceci est un test', 'kevin78', '2012-05-10 10:56:01', '05/29/2012', '17h01', 'Torcy, France', 'Football', 'Petit 8 contre 8 au Jorki, préparez 8€ chacun', 16, 1, 0, 'Devant le pôle emploi', ''),
(74, '3participants', 'niklas', '2012-05-26 18:23:20', '06/28/2012', '07h10', 'Saint-Ouen, France', 'Basketball', 'voici un test', 3, 1, 0, 'paris', ''),
(75, 'Partie a deux ', 'kevin78', '2012-05-27 14:20:13', '05/28/2012', '02h02', 'Aubervilliers, France', 'Basketball', 'Je propose un contre un !', 2, 1, 0, 'aubergenville', ''),
(78, 'Rolland Garros en 2 contre 2', 'Duplo', '2012-06-08 16:30:05', '06/30/2012', '12h04', 'Le Bon Marche, Paris, France', 'Tennis', 'Super match de tennis', 4, 1, 0, 'devant le décatlon', ''),
(91, 'Nba live', 'Duplo', '2012-06-18 21:25:26', '06/16/2012', '12h15', 'Paris-La Défense, France', 'Basketball', 'Petit match amical entre amis', 8, 1, 0, 'Jardin devant le cnit', ''),
(92, 'Petit match de rugby entre amis', 'Duplo', '2012-06-18 21:40:59', '06/28/2012', '14h13', 'Pressing 4 Temps, Achères, France', 'Rugby', 'Venez vous mesurer à nous ;)', 30, 1, 0, 'Devant décatlhon', ''),
(93, 'ezr', 'Flokie', '2012-06-18 22:18:18', '06/22/2012', '18h10', 'Courbevoie, Place de l\\''Hôtel de ville, France', 'Rugby', 'Création d\\''un évènement test', 10, 1, 0, 'gare de bécon les bruyeres', ''),
(94, 'FootTest', 'kevin78', '2012-06-23 15:30:29', '06/24/2012', '03h05', 'Aubervilliers, France', 'Football', 'Un petit foot entre amis', 2, 1, 0, 'aubergenville', ''),
(95, 'Footballlkd', 'kevin78', '2012-06-24 00:00:17', '06/24/2012', '03h04', 'Aubervilliers, France', 'Football', 'test02', 2, 1, 0, 'aubergenville', ''),
(96, 'Run', 'kevin78', '2012-06-24 00:05:20', '07/01/2012', '03h02', 'Paris, France', 'Running', 'Run run run', 3, 1, 0, 'paris', '');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `statut`) VALUES
(1, 1, 2, 1),
(2, 2, 1, 1),
(3, 3, 4, 1),
(4, 4, 3, 1),
(5, 1, 3, 1),
(7, 3, 1, 1),
(8, 3, 6, 1),
(9, 6, 3, 1),
(10, 6, 4, 1),
(11, 4, 6, 1),
(12, 1, 5, 1),
(13, 5, 1, 1),
(14, 92, 88, 1),
(15, 88, 92, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message_home`
--

CREATE TABLE IF NOT EXISTS `message_home` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `message_home`
--

INSERT INTO `message_home` (`id`, `message`) VALUES
(1, 'Non sérieux s’abstenir : les organisateurs choisissent les sportifs en fonction des notes que leur auront attribuées leurs partenaires après de précédentes rencontres !');

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `n_participant` int(11) NOT NULL,
  `n_orga` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `publicite`
--

CREATE TABLE IF NOT EXISTS `publicite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lien` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `publicite`
--

INSERT INTO `publicite` (`id`, `lien`, `img`) VALUES
(1, 'dzdz', 'publicite.png');

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE IF NOT EXISTS `sports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sport` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`id`, `sport`) VALUES
(1, 'Running'),
(4, 'Tennis'),
(3, 'Basketball'),
(2, 'Rugby'),
(5, 'Football');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(30) COLLATE utf8_bin NOT NULL,
  `fname` varchar(100) COLLATE utf8_bin NOT NULL,
  `lname` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(200) COLLATE utf8_bin NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(30) COLLATE utf8_bin NOT NULL,
  `confirmed` int(1) NOT NULL,
  `tel` int(20) NOT NULL,
  `city` varchar(100) COLLATE utf8_bin NOT NULL,
  `postal` int(10) NOT NULL,
  `hash` varchar(255) COLLATE utf8_bin NOT NULL,
  `actif` int(1) NOT NULL,
  `login` varchar(100) COLLATE utf8_bin NOT NULL,
  `pass` varchar(255) COLLATE utf8_bin NOT NULL,
  `mail` varchar(255) COLLATE utf8_bin NOT NULL,
  `avatar` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT 'gris.png',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=99 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `fname`, `lname`, `email`, `date`, `ip`, `confirmed`, `tel`, `city`, `postal`, `hash`, `actif`, `login`, `pass`, `mail`, `avatar`) VALUES
(29, 'pass', 'fname', 'lname', 'kev@gmail.com', '2012-03-10 15:39:34', '2343242', 0, 123213, 'paris', 2341, '', 0, 'login', 'f22270d749cb34a72182963ead456cd8a4ed6291', '', ''),
(30, 'niklas', 'Niklas', 'Ed', 'kev@gmail.com', '2012-03-10 15:45:38', '88.180.117.16', 0, 2147483647, 'neuilly sur seine', 92200, '', 0, '', 'f22270d749cb34a72182963ead456cd8a4ed6291', '', ''),
(31, 'niklas', 'Niklas', 'Ed', 'kev@gmail.com', '2012-03-10 16:15:57', '88.180.117.16', 0, 2147483647, 'neuilly sur seine', 92200, '', 0, '', 'f22270d749cb34a72182963ead456cd8a4ed6291', '', ''),
(32, 'azerty', 'Bart', 'Test', 'kev@gmail.com', '2012-03-11 17:52:16', '213.245.232.249', 0, 0, '', 0, '', 0, '', 'f22270d749cb34a72182963ead456cd8a4ed6291', '', ''),
(34, 'pass', 'fname', 'lname', 'kev@gmail.com', '2012-03-14 13:49:54', '2343242', 0, 123213, 'paris', 2341, '', 0, '', 'f22270d749cb34a72182963ead456cd8a4ed6291', '', ''),
(64, '', 'juju', 'keke', 'kev@gmail.com', '2012-03-20 16:39:29', '', 0, 0, 'da', 0, 'e8c0653fea13f91bf3c48159f7c24f78', 1, 'kevin', 'f22270d749cb34a72182963ead456cd8a4ed6291', '', ''),
(63, '', 'Kevin', 'Harrang', 'kev@gmail.com', '2012-03-20 16:02:22', '', 0, 130, 'aubergenville', 78410, '24896ee4c6526356cc127852413ea3b4', 1, '', 'f22270d749cb34a72182963ead456cd8a4ed6291', '', ''),
(65, '', 'kevin', 'kevin', 'kev@gmail.com', '2012-03-20 17:07:47', '', 0, 0, 'd', 0, '74bba22728b6185eec06286af6bec36d', 1, '', 'f22270d749cb34a72182963ead456cd8a4ed6291', '', ''),
(89, '', 'Olivier', 'F', 'ienesis@hotmail.com', '2012-05-20 09:58:11', '', 0, 619191919, 'Paris', 75012, '6c8349cc7260ae62e3b1396831a8398f', 1, 'ienesis', 'a010b72dac9727ba7e60c4fda46694262df561a2', '', ''),
(67, '', 'dqzd', 'Harrang', 'kevinharr.a.ng@gmail.com', '2012-03-22 12:36:44', '', 0, 0, 'dqz', 0, '67e103b0761e60683e83c559be18d40c', 1, 'kevin2', '37cd98ec07c06c4c6d44edaf7d620b894c0408b0', '', ''),
(68, '', 'niklas', 'Ed', 'niklas@hotmail.com', '2012-03-31 13:04:08', '', 0, 635244120, 'paris', 75000, '33e75ff09dd601bbe69f351039152189', 1, 'niklas', '61ebf6bc14ce01e4cc9d59ee9f469c902ea13918', '', ''),
(69, '', 'barthoche', 'chauv', 'bartchauvin@gmail.com', '2012-04-05 11:44:45', '', 0, 0, 'iuhosuh', 0, '96da2f590cd7246bbde0051047b0d6f7', 1, 'bart', '9d90285bac26741ab7dd09a5fcf8601e130695f7', '', ''),
(70, '', 'kevin', 'harrang', 'kevi.nharrang@gmail.com', '2012-04-11 18:55:44', '', 0, 130901549, 'auber', 78410, '65ded5353c5ee48d0b7d48c591b8f430', 1, 'kev', '37cd98ec07c06c4c6d44edaf7d620b894c0408b0', '', ''),
(77, '', '', '', '', '2012-04-23 21:37:17', '', 0, 0, '', 0, '85d8ce590ad8981ca2c8286f79f59954', 1, 'Flokie', 'c81a0a472ee8fa9878757ca94c285fb76c794911', '', 'braultf-hotmail.fr-f27d5b31-1-.jpg'),
(76, '', 'Bart', 'TEst', 'smatoox.is.bart@gmail.com', '2012-04-22 16:34:57', '', 0, 0, 'Paris', 75004, '68053af2923e00204c3ca7c6a3150cf7', 1, 'bartichon', '2e6f9b0d5885b6010f9167787445617f553a735f', '', ''),
(75, '', 'dzqd', 'adzq', 'kdjzqkdjzq@gmail.com', '2012-04-22 16:07:35', '', 0, 2, 'dzqd', 3, 'bd4c9ab730f5513206b999ec0d90d1fb', 0, 'jkjkjk', '9cf95dacd226dcf43da376cdb6cbba7035218921', '', ''),
(74, '', 'ke', 'har', 'kevinharra.ng@gmail.com', '2012-04-22 16:02:43', '', 0, 130901549, 'auber', 130901562, 'bbf94b34eb32268ada57a3be5062fe7d', 1, 'kevin78410', '37cd98ec07c06c4c6d44edaf7d620b894c0408b0', '', ''),
(78, '', 'Mon Prénom', 'Mon Nom', 'bap.sportbook@gmail.com', '2012-04-24 08:58:41', '', 0, 102030405, 'BartVille', 0, '75fc093c0ee742f6dddaa13fff98f104', 1, 'Duplo', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', ''),
(79, '', 'Brault', 'Flo', 'flo@hotmail.fr', '2012-04-25 11:37:34', '', 0, 0, 'Paris', 0, '16a5cdae362b8d27a1d8f8c7b78b4330', 0, 'flo', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', ''),
(80, '', 'Ornella', 'Joum', 'candies@msn.com', '2012-05-07 16:57:27', '', 0, 603580978, 'Maule', 78580, '84d9ee44e457ddef7f2c4f25dc8fa865', 0, 'Fingirldetoi', '7cdbbef3dc01662b854d1bde0766c2590617b051', '', ''),
(81, '', 'testprenom', 'testnom', 'niklas@hotmail.com', '2012-05-11 06:27:08', '', 0, 12342121, 'testville', 21300, 'd3d9446802a44259755d38e6d163e820', 1, 'testlogin', '0e4874939fc782c0ae46ad81f1ea215c4cf653f4', '', ''),
(88, '', 'Kévin', 'Harrang', 'kevin@gmail.com', '2012-05-17 16:50:01', '', 0, 32031515, 'Ldk', 78420, '7c590f01490190db0ed02a5070e20f01', 1, 'kevin78', '9cf95dacd226dcf43da376cdb6cbba7035218921', '', 'BREMOND-IRYNA.jpg'),
(90, '', 'dzqdzq', 'dzqd', 'ke.vin.ha.rra.ng@gmail.com', '2012-05-20 16:48:08', '', 0, 320302302, 'qzdzqdq', 32, '258be18e31c8188555c2ff05b4d542c3', 1, 'kevin788', '9cf95dacd226dcf43da376cdb6cbba7035218921', '', 'gris.png'),
(91, '', 'ldl', 'l', 'k.e.v.i.nharrang@gmail.com', '2012-05-27 13:39:20', '', 0, 301254630, 'dld', 45125, 'b337e84de8752b27eda3a12363109e80', 5, 'admin', '9cf95dacd226dcf43da376cdb6cbba7035218921', '', 'gris.png'),
(92, '', 'Pierre', 'Blanc-Pain', 'pierren@gmail.com', '2012-05-28 09:06:16', '', 0, 1234567894, 'Levallois', 92300, '28f0b864598a1291557bed248a998d4e', 1, 'pierre', '8cb2237d0679ca88db6464eac60da96345513964', '', 'gris.png'),
(93, '', 'sophie', 'robalo', 'sophie@gmail.com', '2012-06-08 15:17:05', '', 0, 677000000, 'argenteuil', 95100, 'b83aac23b9528732c23cc7352950e880', 1, 'robalosophie', '0cb2e69d9e329e9904dd0b431bfd2e29861c915d', '', 'gris.png'),
(94, '', 'dzqdzqd', 'dqdz', 'k.ev.inh.arrang@gmail.com', '2012-06-13 21:50:58', '', 0, 120302623, 'dzqdqdz', 78451, 'd516b13671a4179d9b7b458a6ebdeb92', 1, 'azerty', '9cf95dacd226dcf43da376cdb6cbba7035218921', '', 'gris.png'),
(95, '', 'De niro', 'Robert', 'monmail@monmail.com', '2012-06-18 19:23:00', '', 0, 102030405, 'Paris', 75007, 'f457c545a9ded88f18ecee47145a72c0', 0, 'monPseudo', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', 'gris.png'),
(96, '', 'De Niro', 'Robert', 'duplo@gmail.com', '2012-06-18 19:39:20', '', 0, 102030405, 'Paris', 75007, 'c4b31ce7d95c75ca70d50c19aef08bf1', 0, 'Duplo2', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', 'gris.png'),
(98, '', 'test', 'd', 'kevin.h.a.rra.ng@gmail.com', '2012-06-23 13:23:44', '', 0, 130901549, 'auber', 7841, '2bcab9d935d219641434683dd9d18a03', 1, 'test05', '4099f2eb67521d1b8719517d5f7c7ba14e6c586c', '', 'gris.png');

-- --------------------------------------------------------

--
-- Table structure for table `users_has_event`
--

CREATE TABLE IF NOT EXISTS `users_has_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_users` int(11) NOT NULL,
  `fk_users_attente` int(11) NOT NULL,
  `fk_users_valide` int(11) NOT NULL,
  `fk_users_refuse` int(11) NOT NULL,
  `fk_event` int(11) NOT NULL,
  `fk_event_attente` int(11) NOT NULL,
  `fk_event_valide` int(11) NOT NULL,
  `fk_event_refuse` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=76 ;

--
-- Dumping data for table `users_has_event`
--

INSERT INTO `users_has_event` (`id`, `fk_users`, `fk_users_attente`, `fk_users_valide`, `fk_users_refuse`, `fk_event`, `fk_event_attente`, `fk_event_valide`, `fk_event_refuse`) VALUES
(33, 68, 0, 68, 0, 72, 0, 72, 0),
(41, 68, 68, 0, 0, 73, 73, 0, 0),
(6, 70, 0, 70, 0, 72, 0, 72, 0),
(21, 70, 0, 70, 0, 68, 0, 68, 0),
(22, 74, 0, 0, 74, 68, 0, 0, 68),
(18, 74, 0, 74, 0, 72, 0, 72, 0),
(25, 75, 0, 0, 75, 72, 0, 0, 72),
(27, 75, 75, 0, 0, 68, 68, 0, 0),
(35, 68, 68, 0, 0, 66, 66, 0, 0),
(43, 81, 0, 0, 81, 68, 0, 0, 68),
(47, 75, 0, 75, 0, 74, 0, 74, 0),
(75, 81, 0, 0, 81, 74, 0, 0, 74),
(46, 70, 0, 70, 0, 74, 0, 74, 0),
(48, 81, 81, 0, 0, 71, 71, 0, 0),
(50, 93, 0, 93, 0, 78, 0, 78, 0),
(51, 93, 0, 93, 0, 78, 0, 78, 0),
(52, 93, 0, 93, 0, 78, 0, 78, 0),
(53, 93, 0, 93, 0, 78, 0, 78, 0),
(54, 93, 0, 93, 0, 78, 0, 78, 0),
(55, 93, 0, 93, 0, 78, 0, 78, 0),
(56, 93, 0, 93, 0, 78, 0, 78, 0),
(66, 78, 78, 0, 0, 74, 74, 0, 0),
(68, 78, 0, 78, 0, 93, 0, 93, 0),
(69, 77, 77, 0, 0, 92, 92, 0, 0);
