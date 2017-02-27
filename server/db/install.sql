

CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(12) NOT NULL,
  `lname` varchar(15) NOT NULL,
  `address` varchar(33) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

INSERT INTO `persons` (`id`, `fname`, `lname`, `address`) VALUES
(1, 'Sylvester', 'Stallone', 'Chicago'),
(2, 'Jason', 'Statham', 'Louisiana'),
(3, 'Arnold', 'Schwarzenegger', 'California'),
(4, 'Chuck', 'Norris', 'Plovdiv'),
(5, 'Bruce', 'Willis', 'California');



CREATE TABLE IF NOT EXISTS `telephones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `teltype_id` int(11) NOT NULL,
  `number` varchar(33) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `telephones` (`id`, `person_id`, `teltype_id`, `number`) VALUES
(1, 1, 1, '032 / 123 4560'),
(2, 2, 2, '011 / 103 482'),
(3, 3, 3, '044 / 333 333'),
(4, 4, 1, '032 / 456 879'),
(5, 5, 1, '032 / 666 666');



CREATE TABLE IF NOT EXISTS `teltypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `teltypes` (`id`, `name`) VALUES
(1, 'Home'),
(2, 'Mobile'),
(3, 'Office');
