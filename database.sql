SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

DROP TABLE IF EXISTS constructionSites;
CREATE TABLE IF NOT EXISTS constructionSites (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `address` varchar(128) NOT NULL,
  `longitude` varchar(128),
  `latitude` varchar(128),
  `startDate` DATE,
  `endDate` DATE,
  `PurposeOfTheProject` text,
  `EarningsOfTheProject` text,
  `PictureOfTheProjectAtTheEnd` text,
  `StreetsConcernedByTheProject` text,
  `RulerOfTheProject` text,
  `CostsOfTheProject` text,
  `WhoIsFundingTheProject` text,
  PRIMARY KEY (`id`)
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS events;
CREATE TABLE IF NOT EXISTS events(
  id int not null auto_increment,
  type varchar(30),
  startDate date,
  endDate date,
  information text,
  constructionSitesId int,
  PRIMARY KEY (id),
  FOREIGN KEY (`constructionSitesId`) REFERENCES constructionsites(id)
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `role` char(1) NOT NULL,
  `constructionSitesId` int(11),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`constructionSitesId`) REFERENCES constructionsites(id)
)DEFAULT CHARSET=utf8;

INSERT INTO `users` (login, password, role) VALUES
  ('Thomas', 'pomme', 'A'),
  ('Arnaud', 'pomme', 'C'),
  ('Salim', 'pomme', 'C');

DROP TABLE IF EXISTS  questionnaire;
CREATE TABLE IF NOT EXISTS questionnaire (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_chantier` int(11) NOT NULL,
  `Q1` text,
  `Q2` text,
  `N12345` text,
  `Q3` text,
  `Q4` text,
  `Q5` text,
  `Q6` text,
  `Q7` text,
  `Q8` text,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_chantier`) REFERENCES constructionSites(id)
)DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;