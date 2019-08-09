-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 09 août 2019 à 08:33
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `password_admin` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password_admin`) VALUES
(1, 'Jean Forteroche', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL,
  `post_id` int(11) NOT NULL,
  `date_comment` datetime NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `name`, `comment`, `post_id`, `date_comment`, `seen`) VALUES
(16, 'sqdq', 'dqsdqsdq', 1, '2019-08-21 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `name_post` varchar(255) COLLATE utf8_bin NOT NULL,
  `image_posts` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'post.png',
  `date_posts` datetime NOT NULL,
  `posted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `name_post`, `image_posts`, `date_posts`, `posted`) VALUES
(1, 'Chapitre 1 : Quand le rêve devient réalité', 'Au coeur d\'une sombre forêt,en pleine nuit,une jeune fille de 17 ans courait,courait et courait encore.Ne sachant pas exactement ce qu\'elle fuyait.Mais le fuyait quand même.Ces yeux rouges sombre,cette peau scintillant au clair de lune,cette beauté a faire pâlir d\'envie Apollon lui même et cette voix,oh cette voix.Estelle n\'avais jamais entendu un son aussi magnifique.Au début,restant méfiante.La jeune demoiselle s\'étais contenter de le dévisager un long moment.Lui,il souriait en coin,une petit lueur brillait dans son regard.C\'étais cette étrange lueur qui la fit fuir.Cet étrange inconnu la regardait comme si elle étais son casse croûte.Comme un lion qui regardait la gazelle qu\'il allait dévorer.Elle comprit alors qu\'il n\'étais pas humain.Et Estelle en étais la,a fuir l\'inconnu qui la rattrapa au bout de même pas 2 min de course.Il se mit en face d\'elle la contemplant quelque instant.Il lui caressa la joue du bout des doigt.La fixant toujours.Estelle ne put que frémir au contact de ses doigt glacer sur sa peau.L\'inconnu descendit ses doigt.Lui caressant maintenant son cou.Elle sentais son excitation grandir,tout comme elle savait pertinemment qu\'il ne lui restait plus beaucoup de temps a vivre.Doucement l\'inconnu s\'approcha d\'elle.La demoiselle étais comme paralysé.L\'homme se rapprochais e plus en plus de son cou,puis y planta ses crocs.Elle hurla de douleur.Lui,commença a aspiré son sang lorsque:\r\n-NE FAIT PAS SA!\r\nL\'homme se retira et dévisagea son interlocuteur.Estelle cessa d\'hurler.Ils étaient sous un chaîne et ses feuilles obscurcissait d\'avantages la sombre forêt.Si bien qu\'elle ne voyais plus les yeux rouges sombres de son &quot;Monstre&quot; Ni la personne qui lui as sauvé la vie.Il la lâcha puis s\'exclama:\r\n-Mais enfin!Laisse moi manger!\r\nL\'autre lui rétorqua que non.Indifférant,son &quot;Monstre replanta ses crocs dans son cou.En colère son &quot;Sauveur &quot; Força l\'inconnu d\'Estelle a se dégager d\'elle et le propulsa plus loin.Ensuite il lui cria de s\'enfuir.Ce qu\'elle fit.Elle entendais encore les bruit de lutte après 5 min de course.Elle sentais quelqu\'un se rapprocher d\'elle.Estelle Accéléra et trébucha.Quelqu\'un la prit par la gorge et.......', 'Jean Forteroche', 'alaska.jpeg', '2019-07-23 17:23:45', 1),
(2, 'Chapitre 2 : Découverte de l\'Alaska', 'Au départ de Skagway (mais également d\'autres villes) vous pouvez réaliser une croisière dans ce qu\'on appelle &quot;le passage intérieur&quot; (Inside Passage). Cette voie maritime côtière de l\'océan pacifique se faufile entre le sud-est de l\'Alaska et le nord-ouest de la Colombie-Britannique. Elle a été très empruntée au moment de la ruée vers l\'or par les prospecteurs. Aujourd\'hui, le tourisme est très développé sur cette voie, ce qui pose des soucis écologiques (et oui, paquebots et glaciers, ça ne fait pas bon ménage). \r\n\r\nQuoi qu\'il en soit, sachez que de quelques heures à plusieurs jours, plusieurs itinéraires sont possibles, et permettent de partir découvrir les îles, fjords et glaciers nichés dans le coin. Vous pouvez même planifier une petite semaine de traversée et descendre tranquillement jusqu\'à l\'île de Vancouver (pour plus d\'infos : www.bcferries.com ).\r\n&lt;br&gt;&lt;br&gt;Nous avons choisi d\'aller visiter Juneau, la capitale de l\'Alaska, accessible uniquement par ferry ou par avion (et oui, il n\'y a pas vraiment de routes pour se rendre dans le sud-est de l\'Alaska...).\r\n\r\nDe Skagway, la traversée en ferry dure 6 heures. Cette voie maritime est époustouflante car vous évoluez tranquillement dans ce passage entouré de montagnes plus belles les unes que les autres. Si avec de la chance, vous avez comme nous, un temps radieux (ce qui n\'est pas souvent le cas, c\'est venteux et pluvieux habituellement), vous pourrez profiter d\'un coucher de soleil inoubliable, tranquillement installé dans le solarium gratuit sur le ponton ! Sur le ferry, sachez qu\'ils servent à manger et que c\'est plutôt correct. Il y a aussi possibilité d\'avoir une cabine mais nous on l\'a bien entendu joué en mode pauvre (surtout pour si peu d\'heures). Allez, let\'s go to Juneau :-)', 'Jean Forteroche', 'intro-bg.jpg', '2019-08-06 19:05:23', 1),
(48, 'Test', '&lt;p&gt;ceci est un article&amp;nbsp;&lt;/p&gt;', 'Jean', 'post.png', '2019-08-07 12:49:52', 1),
(49, 'Test', '&lt;p&gt;ceci est un article&amp;nbsp;&lt;/p&gt;', 'Jean', 'post.png', '2019-08-07 12:51:11', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
