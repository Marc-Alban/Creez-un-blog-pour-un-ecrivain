-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 21 août 2019 à 16:28
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
(1, 'Jean Forteroche', '$2y$10$9XGSE3Wml7xODzxU5TUcCunlgbSnjwCLJkAow0/m0isYd3gwVejEm');

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
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `name_post`, `image_posts`, `date_posts`, `posted`) VALUES
(1, 'Chapitre 2 : Quand le rÃªve devient rÃ©alitÃ©', '<p>Au <strong>coeur</strong> d\'une sombre for&ecirc;t,en pleine nuit,une jeune fille de 17 ans courait,courait et courait encore.Ne sachant pas exactement ce qu\'elle fuyait.Mais le fuyait quand m&ecirc;me.Ces yeux rouges sombre,cette peau scintillant au clair de lune,cette beaut&eacute; a faire p&acirc;lir d\'envie Apollon lui m&ecirc;me et cette voix,oh cette voix.Estelle n\'avais jamais entendu un son aussi magnifique.Au d&eacute;but,restant m&eacute;fiante.La jeune demoiselle s\'&eacute;tais contenter de le d&eacute;visager un long moment.Lui,il souriait en coin,une petit lueur brillait dans son regard.C\'&eacute;tais cette &eacute;trange lueur qui la fit fuir.Cet &eacute;trange inconnu la regardait comme si elle &eacute;tais son casse cro&ucirc;te.Comme un lion qui regardait la gazelle qu\'il allait d&eacute;vorer.Elle comprit alors qu\'il n\'&eacute;tais pas humain.Et Estelle en &eacute;tais la,a fuir l\'inconnu qui la rattrapa au bout de m&ecirc;me pas 2 min de course.Il se mit en face d\'elle la contemplant quelque instant.Il lui caressa la joue du bout des doigt.La fixant toujours.Estelle ne put que fr&eacute;mir au contact de ses doigt glacer sur sa peau.L\'inconnu descendit ses doigt.Lui caressant maintenant son cou.Elle sentais son excitation grandir,tout comme elle savait pertinemment qu\'il ne lui restait plus beaucoup de temps a vivre.Doucement l\'inconnu s\'approcha d\'elle.La demoiselle &eacute;tais comme paralys&eacute;.L\'homme se rapprochais e plus en plus de son cou,puis y planta ses crocs.Elle hurla de douleur.Lui,commen&ccedil;a a aspir&eacute; son sang lorsque: -NE FAIT PAS SA! L\'homme se retira et d&eacute;visagea son interlocuteur.Estelle cessa d\'hurler.Ils &eacute;taient sous un cha&icirc;ne et ses feuilles obscurcissait d\'avantages la sombre for&ecirc;t.Si bien qu\'elle ne voyais plus les yeux rouges sombres de son \"Monstre\" Ni la personne qui lui as sauv&eacute; la vie.Il la l&acirc;cha puis s\'exclama: -Mais enfin!Laisse moi manger! L\'autre lui r&eacute;torqua que non.Indiff&eacute;rant,son \"Monstre replanta ses crocs dans son cou.En col&egrave;re son \"Sauveur \" For&ccedil;a l\'inconnu d\'Estelle a se d&eacute;gager d\'elle et le propulsa plus loin.Ensuite il lui cria de s\'enfuir.Ce qu\'elle fit.Elle entendais encore les bruit de lutte apr&egrave;s 5 min de course.Elle sentais quelqu\'un se rapprocher d\'elle.Estelle Acc&eacute;l&eacute;ra et tr&eacute;bucha.Quelqu\'un la prit par la gorge et.......</p>', 'Jean Forteroche', '1.png', '2019-08-21 18:24:37', 1),
(69, 'Chapitre 1: Le rÃªve de partir... ? ', '<p style=\"text-align: center;\">Je suis le <em><strong>chapitre 1&nbsp;</strong></em></p>', 'Jean', '1.jpg', '2019-08-21 18:26:13', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
