DROP TABLE IF EXISTS `accounts` ;
CREATE TABLE IF NOT EXISTS `accounts` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_fname` varchar(100) NOT NULL,
  `a_lname` varchar(100) NOT NULL,
  `a_email` varchar(100) NOT NULL,
  `a_login` varchar(100) NOT NULL,
  `a_pass` varchar(32) NOT NULL,
  `a_regdate` datetime NOT NULL,
  PRIMARY KEY (`a_id`),
  UNIQUE KEY `a_email` (`a_email`),
  UNIQUE KEY `a_login` (`a_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;