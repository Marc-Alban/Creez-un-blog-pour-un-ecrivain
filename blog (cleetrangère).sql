-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 02 oct. 2019 à 16:28
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password_admin`) VALUES
(1, 'Admin', '$2y$10$Q8cI98XlNbfKw5KDqaoDYe6X3QWegAdFRMsTqb50LnIIDj0764osi');

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
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `name`, `comment`, `post_id`, `date_comment`, `seen`) VALUES
(164, 'Jean-Michel', 'J\'adore ce site ! : )', 76, '2019-10-01 20:24:25', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `name_post`, `image_posts`, `date_posts`, `posted`) VALUES
(1, 'Chapitre 1: La bataille des crocs.', '<p><span style=\"color: #000000; font-family: \'EB Garamond\', serif; font-size: 20px;\">C\'&eacute;tait la louve qui, la premi&egrave;re, avait entendu le son des voix humaines et les aboiements haletants des chiens attel&eacute;s aux tra&icirc;neaux. La premi&egrave;re, elle avait fui loin de l\'homme recroquevill&eacute; dans son cercle de flammes &agrave; demi &eacute;teintes. Les autres loups ne pouvaient se r&eacute;signer &agrave; renoncer &agrave; cette proie r&eacute;duite &agrave; merci et, durant quelques minutes, ils demeur&egrave;rent encore sur place, &eacute;coutant les bruits suspects qui s\'approchaient d\'eux. Finalement, eux aussi prirent peur et ils s\'&eacute;lanc&egrave;rent sur la trace marqu&eacute;e par la louve. Un grand loup gris, un des chefs de file habituels de la troupe, courait en t&ecirc;te. Il grondait pour avertir les plus jeunes de ne point rompre l\'alignement, et leur distribuait au besoin des coups de crocs s\'ils avaient la pr&eacute;tention de passer devant lui. Il augmenta son allure &agrave; l\'aspect de la louve, qui maintenant trottait avec tranquillit&eacute; dans la neige, et ne tarda pas &agrave; la rejoindre. Elle vint se ranger d\'elle-m&ecirc;me &agrave; son c&ocirc;t&eacute; comme si c\'&eacute;tait l&agrave; sa position coutumi&egrave;re, et ils prirent tous deux la direction de la horde. Le grand loup gris ne grondait pas et ne montrait pas les dents quand, d\'un bond, elle s\'amusait &agrave; prendre sur lui quelque avance. Il semblait, au contraire, lui t&eacute;moigner une vive bienveillance, une bienveillance tellement vive qu\'il tendait sans cesse &agrave; se rapprocher plus pr&egrave;s d\'elle. Et c\'&eacute;tait elle alors qui grondait et montrait ses crocs. Elle allait, &agrave; l\'occasion, jusqu\'&agrave; le mordre durement &agrave; l\'&eacute;paule, ce qu\'il acceptait sans col&egrave;re. Il se contentait de faire un saut de c&ocirc;t&eacute; et, se tenant &agrave; l\'&eacute;cart de son irascible compagne, continuait &agrave; conduire la troupe d\'un air raide et vex&eacute;, comme un amoureux &eacute;conduit. Ainsi escort&eacute;e &agrave; sa droite, la louve &eacute;tait flanqu&eacute;e, &agrave; sa gauche, d\'un vieux loup gris&acirc;tre et pel&eacute;, tout marqu&eacute; des stigmates de maintes batailles. Il ne poss&eacute;dait plus qu\'un &oelig;il, qui &eacute;tait l\'&oelig;il droit, ce qui expliquait la place qu\'il avait choisie par rapport &agrave; la louve. Lui aussi mettait une obstination continue &agrave; la serrer de pr&egrave;s. De son museau balafr&eacute;, il effleurait sa hanche, son &eacute;paule ou son cou. Elle le tenait &agrave; distance, comme elle faisait avec son autre galant. Parfois les deux rivaux la pressaient simultan&eacute;ment, en la bousculant avec rudesse et, pour se d&eacute;gager, elle redoublait &agrave; droite et &agrave; gauche ses morsures aigu&euml;s. Tout en galopant de chaque c&ocirc;t&eacute; d\'elle, les deux loups se mena&ccedil;aient de leurs dents luisantes. Seule, la faim, plus imp&eacute;rieuse que l\'amour, les emp&ecirc;chait de se battre. Le vieux loup borgne avait pr&egrave;s de lui, du c&ocirc;t&eacute; oppos&eacute; &agrave; la louve, un jeune loup de trois ans arriv&eacute; au terme de sa croissance, et qui pouvait passer pour un des plus vigoureux de la troupe. Les deux b&ecirc;tes, quand elles &eacute;taient lasses, s\'appuyaient amicalement l\'une sur l\'autre, de l\'&eacute;paule ou de la t&ecirc;te. Mais le jeune loup, par moment, ralentissant sa marche d\'un air innocent, se laissait d&eacute;passer par son vieux compagnon et, sans &ecirc;tre aper&ccedil;u, se glissait entre lui et la louve. La louve, fr&ocirc;l&eacute;e par ce troisi&egrave;me loup, se mettait &agrave; gronder et se retournait. Le vieux loup en faisait autant, et aussi le grand loup gris qui &eacute;tait &agrave; droite. Devant cette triple rang&eacute;e de dents redoutables, le jeune loup s\'arr&ecirc;tait brusquement et s\'asseyait sur son derri&egrave;re, droit sur ses pattes de devant, grin&ccedil;ant des crocs, lui aussi, en h&eacute;rissant le poil de son dos. Une confusion g&eacute;n&eacute;rale en r&eacute;sultait parmi les autres loups, ceux qui fermaient la marche pressant ceux du front, qui finalement s\'en prenaient au jeune loup et lui administraient des coups de crocs &agrave; foison. Il supportait ce traitement sans broncher et, avec la foi sans limites qui est l\'apanage de la jeunesse, il r&eacute;p&eacute;tait de temps &agrave; autre sa man&oelig;uvre, quoiqu\'elle ne lui rapport&acirc;t rien de bon...</span></p>', 'Jean Forteroche', '1.jpeg', '2019-09-24 13:56:42', 1),
(76, 'Chapitre 2 : La piste de la viande.', '<p><span style=\"color: #000000; font-family: \'EB Garamond\', serif; font-size: 20px;\">De chaque c&ocirc;t&eacute; du fleuve glac&eacute;, l\'immense for&ecirc;t de sapins s\'allongeait, sombre et mena&ccedil;ante. Les arbres, d&eacute;barrass&eacute;s par un vent r&eacute;cent de leur blanc manteau de givre, semblaient s\'accouder les uns sur les autres, noirs et fatidiques dans le jour qui p&acirc;lissait. La terre n\'&eacute;tait qu\'une d&eacute;solation infinie et sans vie o&ugrave; rien ne bougeait, et elle &eacute;tait si froide, si abandonn&eacute;e que la pens&eacute;e s\'enfuyait, devant elle, au-del&agrave; m&ecirc;me de la tristesse. Une envie de rire s\'emparait de l\'esprit, rire tragique comme celui du Sphinx, rire transi et sans joie, comme le sarcasme de l\'&Eacute;ternit&eacute; devant la futilit&eacute; de l\'existence et les vains efforts de notre &ecirc;tre. C\'&eacute;tait le Wild. Le Wild farouche, glac&eacute; jusqu\'au c&oelig;ur, de la terre du Nord. Sur la glace du fleuve, et comme un d&eacute;fi au n&eacute;ant du Wild, peinait un attelage de chiens-loups. Leur fourrure, h&eacute;riss&eacute;e, s\'alourdissait de neige. &Agrave; peine sorti de leur bouche, leur souffle se condensait en vapeur pour geler presque aussit&ocirc;t et retomber sur eux en cristaux transparents, comme s\'ils avaient &eacute;cum&eacute; des gla&ccedil;ons. Des courroies de cuir sanglaient les chiens et des harnais les attachaient &agrave; un tra&icirc;neau qui suivait, assez loin derri&egrave;re eux, tout cahot&eacute;. Le tra&icirc;neau, sans patins, &eacute;tait form&eacute; d\'&eacute;corces de bouleau solidement li&eacute;es entre elles, et reposait sur la neige de toute sa surface. Son avant &eacute;tait recourb&eacute; en forme de rouleau afin qu\'il rejet&acirc;t sous lui, sans s\'y enfoncer, l\'amas de neige molle qui accumulait ses vagues moutonnantes.&nbsp;</span><br style=\"color: #ffffff; font-family: \'EB Garamond\', serif; font-size: 20px;\" /><span style=\"color: #000000; font-family: \'EB Garamond\', serif; font-size: 20px;\">Une grande bo&icirc;te, &eacute;troite et oblongue, &eacute;tait fortement attach&eacute;e sur letra&icirc;neau et prenait presque toute la place. &Agrave; c&ocirc;t&eacute; d\'elle se tassaient divers objets : des couvertures, une hache, une cafeti&egrave;re et une po&ecirc;le &agrave; frire. Devant les chiens, peinait un homme sur de larges raquettes, et derri&egrave;re le tra&icirc;neau, un autre homme. Dans la bo&icirc;te qui &eacute;tait sur le tra&icirc;neau en gisait un troisi&egrave;me dont le souci &eacute;tait fini. Celui-l&agrave;, le Wild l\'avait abattu, et si bien qu\'il ne conna&icirc;trait jamais plus le mouvement ni la lutte. Le mouvement r&eacute;pugne au Wild et la vie lui est une offense. Il cong&egrave;le l\'eau pour l\'emp&ecirc;cher de courir &agrave; la mer ; il glace la s&egrave;ve sous l\'&eacute;corce puissante des arbres jusqu\'&agrave; ce qu\'ils en meurent et, plus f&eacute;rocement encore, plus implacablement, il s\'acharne sur l\'homme pour le soumettre &agrave; lui et l\'&eacute;craser. Car l\'homme est le plus agit&eacute; de tous les &ecirc;tres, jamais en repos et jamais las, et le Wild hait le mouvement. Cependant, les deux hommes qui n\'&eacute;taient pas encore morts trimaient en avant et en arri&egrave;re du tra&icirc;neau, indomptables et sans perdre courage. Ils &eacute;taient v&ecirc;tus de fourrures et de cuir souple tann&eacute;. Leur haleine avait recouvert leurs paupi&egrave;res, leurs joues, leurs l&egrave;vres et toute leur figure de cristallisations glac&eacute;es, en se gelant comme celle des chiens, si bien qu\'il e&ucirc;t &eacute;t&eacute; impossible de les distinguer l\'un de l\'autre. On e&ucirc;t dit des croque-morts masqu&eacute;s conduisant les fun&eacute;railles de quelque fant&ocirc;me en un monde surnaturel. Mais sous ce masque, il y avait des hommes qui avan&ccedil;aient malgr&eacute; tout sur cette terre d&eacute;sol&eacute;e, m&eacute;prisants de sa railleuse ironie et dress&eacute;s, quelque ch&eacute;tifs qu\'ils fussent, contre la puissance d\'un monde qui leur &eacute;tait aussi &eacute;tranger, aussi hostile et impassible que l\'ab&icirc;me infini de l\'espace. Ils avan&ccedil;aient, les muscles tendus, &eacute;vitant tout effort inutile et m&eacute;nageant jusqu\'&agrave; leur souffle. Partout autour d\'eux &eacute;tait le silence, le silence qui les &eacute;crasait de son poids lourd, comme p&egrave;se l\'eau sur le corps du plongeur au fur et &agrave; mesure qu\'il s\'enfonce plus avant aux profondeurs de l\'Oc&eacute;an. Une heure passa, puis une deuxi&egrave;me heure.&nbsp;</span></p>', 'Jean Forteroche', '76.png', '2019-10-01 20:44:14', 1),
(83, 'Chapitre 3: la revanche', '<p style=\"box-sizing: border-box; margin: 0px 0px 10px;\"><strong><em><span style=\"vertical-align: inherit;\"><span style=\"vertical-align: inherit;\">Il </span></span><span style=\"vertical-align: inherit;\"><span style=\"vertical-align: inherit;\">arrive</span></span></em></strong><span style=\"vertical-align: inherit;\"><span style=\"vertical-align: inherit;\"><strong><em> sur un lieu d\'accidents, un policier s\'approche</em></strong> de lui et demande de faire demi-tour. </span><span style=\"vertical-align: inherit;\">Au m&ecirc;me moment, le policier remarque le visage du jeune homme lui est familier, il marque le jeune homme pr&eacute;sent sur les photos retrouv&eacute;es au milieu des papiers d\'identit&eacute; des victimes, qu\'il comprenne vite qu\'il s\'agissa du fils.</span></span></p>', 'Jean Forteroche', '83.jpg', '2019-10-02 09:39:08', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
