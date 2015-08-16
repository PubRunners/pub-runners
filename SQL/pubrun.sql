-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 16, 2015 at 05:57 AM
-- Server version: 5.1.73
-- PHP Version: 5.3.2-1ubuntu4.26

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pubrun`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--
-- Creation: Aug 04, 2014 at 11:15 AM
-- Last update: Aug 18, 2014 at 09:38 PM
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(100) NOT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `contact_email` varchar(250) DEFAULT NULL,
  `active_flag` char(1) DEFAULT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--
-- Creation: Aug 04, 2014 at 11:15 AM
-- Last update: Mar 30, 2015 at 08:21 AM
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(100) NOT NULL,
  `event_date` date DEFAULT NULL,
  `event_link` varchar(100) DEFAULT NULL,
  `event_comments` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `front_page`
--
-- Creation: Aug 04, 2014 at 11:15 AM
-- Last update: Aug 20, 2014 at 08:01 PM
--

DROP TABLE IF EXISTS `front_page`;
CREATE TABLE IF NOT EXISTS `front_page` (
  `page_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `heading` varchar(100) DEFAULT NULL,
  `text` varchar(1000) DEFAULT NULL,
  `image_position1` varchar(100) DEFAULT NULL,
  `image_position2` varchar(100) DEFAULT NULL,
  `image_position3` varchar(100) DEFAULT NULL,
  `active_flag` char(1) DEFAULT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `front_page_bak`
--
-- Creation: Aug 04, 2014 at 11:15 AM
-- Last update: Aug 04, 2014 at 11:15 AM
--

DROP TABLE IF EXISTS `front_page_bak`;
CREATE TABLE IF NOT EXISTS `front_page_bak` (
  `front_page_id` int(11) NOT NULL DEFAULT '0',
  `page_order` int(11) DEFAULT NULL,
  `photo_link` varchar(250) DEFAULT NULL,
  `heading` varchar(250) DEFAULT NULL,
  `page_text` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `news_item`
--
-- Creation: Aug 04, 2014 at 11:15 AM
-- Last update: Jul 11, 2015 at 11:33 AM
--

DROP TABLE IF EXISTS `news_item`;
CREATE TABLE IF NOT EXISTS `news_item` (
  `news_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_date` date DEFAULT NULL,
  `item_title` varchar(200) DEFAULT NULL,
  `item_body` varchar(3000) DEFAULT NULL,
  `item_author` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`news_item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `result`
--
-- Creation: Aug 04, 2014 at 11:15 AM
-- Last update: Aug 14, 2015 at 01:59 AM
--

DROP TABLE IF EXISTS `result`;
CREATE TABLE IF NOT EXISTS `result` (
  `result_id` int(11) NOT NULL AUTO_INCREMENT,
  `result_set_id` int(11) DEFAULT NULL,
  `runner_id` int(11) DEFAULT NULL,
  `result_hour` int(11) DEFAULT NULL,
  `result_min` int(11) DEFAULT NULL,
  `result_sec` int(11) DEFAULT NULL,
  PRIMARY KEY (`result_id`),
  KEY `result_set_id` (`result_set_id`),
  KEY `runner_id` (`runner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1034 ;

-- --------------------------------------------------------

--
-- Table structure for table `result_set`
--
-- Creation: Aug 04, 2014 at 11:15 AM
-- Last update: Aug 14, 2015 at 01:57 AM
--

DROP TABLE IF EXISTS `result_set`;
CREATE TABLE IF NOT EXISTS `result_set` (
  `result_set_id` int(11) NOT NULL AUTO_INCREMENT,
  `track_id` int(11) DEFAULT NULL,
  `result_date` date DEFAULT NULL,
  PRIMARY KEY (`result_set_id`),
  KEY `track_id` (`track_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

-- --------------------------------------------------------

--
-- Table structure for table `runner`
--
-- Creation: Aug 04, 2014 at 11:15 AM
-- Last update: Aug 14, 2015 at 01:55 AM
--

DROP TABLE IF EXISTS `runner`;
CREATE TABLE IF NOT EXISTS `runner` (
  `runner_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`runner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=99 ;

-- --------------------------------------------------------

--
-- Table structure for table `track`
--
-- Creation: Aug 04, 2014 at 11:15 AM
-- Last update: Jul 21, 2015 at 10:55 PM
--

DROP TABLE IF EXISTS `track`;
CREATE TABLE IF NOT EXISTS `track` (
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `track_name` varchar(50) DEFAULT NULL,
  `track_length` int(11) DEFAULT NULL,
  `track_link` varchar(250) DEFAULT NULL,
  `track_description` varchar(1000) DEFAULT NULL,
  `track_photo` varchar(250) DEFAULT NULL,
  `pubrun_flag` char(1) DEFAULT NULL,
  PRIMARY KEY (`track_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--
-- Creation: Aug 04, 2014 at 11:15 AM
-- Last update: Aug 18, 2014 at 11:34 AM
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT NULL,
  `userid` varchar(25) NOT NULL,
  `password` char(40) NOT NULL,
  `active_flag` char(1) DEFAULT NULL,
  `user_role` varchar(20) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_results`
--
DROP VIEW IF EXISTS `vw_results`;
CREATE TABLE IF NOT EXISTS `vw_results` (
`result_set_id` int(11)
,`result_id` int(11)
,`runner_id` int(11)
,`result_date` date
,`runner` varchar(101)
,`time` varbinary(8)
,`date` varchar(10)
,`track` varchar(50)
,`track_id` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_result_set`
--
DROP VIEW IF EXISTS `vw_result_set`;
CREATE TABLE IF NOT EXISTS `vw_result_set` (
`result_set_id` int(11)
,`track_id` int(11)
,`track` varchar(50)
,`date` varchar(10)
,`participants` bigint(21)
,`fastest_time` varbinary(8)
,`average_time` varbinary(8)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_runner`
--
DROP VIEW IF EXISTS `vw_runner`;
CREATE TABLE IF NOT EXISTS `vw_runner` (
`runner_id` int(11)
,`runner` varchar(101)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_tracks`
--
DROP VIEW IF EXISTS `vw_tracks`;
CREATE TABLE IF NOT EXISTS `vw_tracks` (
`track_id` int(11)
,`Track` varbinary(66)
);
-- --------------------------------------------------------

--
-- Structure for view `vw_results`
--
DROP TABLE IF EXISTS `vw_results`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_results` AS select `r`.`result_set_id` AS `result_set_id`,`r`.`result_id` AS `result_id`,`r`.`runner_id` AS `runner_id`,`rs`.`result_date` AS `result_date`,concat(concat(`ru`.`first_name`,' '),`ru`.`surname`) AS `runner`,concat(concat(concat(concat(lpad(ifnull(`r`.`result_hour`,0),2,0),':'),lpad(ifnull(`r`.`result_min`,0),2,0),':'),lpad(ifnull(`r`.`result_sec`,0),2,0))) AS `time`,date_format(`rs`.`result_date`,'%d-%m-%Y') AS `date`,(select `t`.`track_name` from `track` `t` where (`t`.`track_id` = (select `a`.`track_id` from `result_set` `a` where (`a`.`result_set_id` = `r`.`result_set_id`)))) AS `track`,(select `a`.`track_id` from `result_set` `a` where (`a`.`result_set_id` = `r`.`result_set_id`)) AS `track_id` from ((`result` `r` join `result_set` `rs` on((`r`.`result_set_id` = `rs`.`result_set_id`))) join `runner` `ru` on((`ru`.`runner_id` = `r`.`runner_id`)));

-- --------------------------------------------------------

--
-- Structure for view `vw_result_set`
--
DROP TABLE IF EXISTS `vw_result_set`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_result_set` AS select `r`.`result_set_id` AS `result_set_id`,`r`.`track_id` AS `track_id`,(select `t`.`track_name` from `track` `t` where (`t`.`track_id` = `r`.`track_id`)) AS `track`,date_format(`r`.`result_date`,'%d-%m-%Y') AS `date`,(select count(`re`.`result_id`) from `result` `re` where (`re`.`result_set_id` = `r`.`result_set_id`)) AS `participants`,(select min(`vw`.`time`) from `vw_results` `vw` where (`vw`.`result_set_id` = `r`.`result_set_id`)) AS `fastest_time`,(select substr(sec_to_time(avg(time_to_sec(`vw`.`time`))),1,8) from `vw_results` `vw` where (`vw`.`result_set_id` = `r`.`result_set_id`)) AS `average_time` from `result_set` `r` order by `r`.`result_date` desc;

-- --------------------------------------------------------

--
-- Structure for view `vw_runner`
--
DROP TABLE IF EXISTS `vw_runner`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_runner` AS select `runner`.`runner_id` AS `runner_id`,concat(concat(`runner`.`first_name`,' '),`runner`.`surname`) AS `runner` from `runner`;

-- --------------------------------------------------------

--
-- Structure for view `vw_tracks`
--
DROP TABLE IF EXISTS `vw_tracks`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_tracks` AS select `track`.`track_id` AS `track_id`,concat(concat(concat(`track`.`track_name`,' - '),`track`.`track_length`),'KM') AS `Track` from `track`;
