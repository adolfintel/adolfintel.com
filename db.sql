SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` int(11) NOT NULL,
  `frag` text NOT NULL,
  `description` text NOT NULL,
  `icon` text NOT NULL,
  `campaignIcon` text DEFAULT NULL,
  `cover` text DEFAULT NULL,
  `title` text NOT NULL,
  `date` date DEFAULT NULL,
  `relevance` decimal(3,2) NOT NULL DEFAULT '0.50',
  `kwords` text NOT NULL,
  `updateFreq` varchar(16) NOT NULL DEFAULT 'never',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;


INSERT INTO `articles` (`id`, `section`, `frag`, `description`, `icon`,`campaignIcon`, `cover`, `title`, `date`, `relevance`, `kwords`, `updateFreq`) VALUES
(1, 1, 'example_project/index.frag', 'Lorem ipsum dolor sit amet...', 'example_project/icon.png',NULL,'example_project/cover.png', 'Example Project', '2015-08-02', 0.9, 'example,app,keyword1,keyword2', 'never'),
(4, 2, 'example_article_2/index.frag', 'Muh article 2 is goat', NULL,NULL,NULL, 'Example Article 2', '2015-08-02', 0.5, 'example,keyword1,keyword2', 'never'),
(3, 2, 'example_article_3/i.frag', 'Smooth scrolling', 'example_article_3/icon.png',NULL,'example_article_3/cover.jpg', 'Example Article 3', '2015-08-02', 0.9, 'example,keyword1,keyword2', 'never');


CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idPage` text NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;


INSERT INTO `comment` (`id`, `idPage`, `text`) VALUES
(1, 'example_article_1/index.frag', 'Very useful');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
