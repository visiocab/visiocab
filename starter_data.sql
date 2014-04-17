-- phpMyAdmin SQL Dump
-- version 3.5.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 17, 2014 at 01:28 PM
-- Server version: 5.0.95-log
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `question_id` bigint(20) unsigned NOT NULL,
  `aorder` int(11) default NULL,
  `correct` int(11) default NULL,
  `atext` text,
  `response` varchar(255) NOT NULL,
  `date_added` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2374 ;


-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL auto_increment,
  `ip_address` varchar(40) collate utf8_bin NOT NULL,
  `login` varchar(50) collate utf8_bin NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `othermedia`
--

CREATE TABLE IF NOT EXISTS `othermedia` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `media` varchar(255) default NULL,
  `notes` text NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;


-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE IF NOT EXISTS `package` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `quiz_id` bigint(20) unsigned default NULL,
  `tour_scene_id` bigint(20) unsigned default NULL,
  `othermedia_id` bigint(20) NOT NULL default '0',
  `date_added` datetime default NULL,
  `creator_user_id` bigint(20) NOT NULL,
  `is_public` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=122 ;


-- --------------------------------------------------------

--
-- Table structure for table `package_items`
--

CREATE TABLE IF NOT EXISTS `package_items` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `package_id` bigint(20) unsigned default NULL,
  `question_id` bigint(20) default NULL,
  `pan` bigint(20) default NULL,
  `tilt` bigint(20) default NULL,
  `coordx` bigint(20) NOT NULL,
  `coordy` bigint(20) NOT NULL,
  `nexttext` varchar(255) NOT NULL,
  `date_added` datetime default NULL,
  `question_order` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=659 ;


-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `quiz_id` bigint(20) unsigned NOT NULL,
  `qtext` text,
  `qtype` varchar(255) default NULL,
  `date_added` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=807 ;


-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `date_added` datetime default NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE IF NOT EXISTS `responses` (
  `id` bigint(20) NOT NULL auto_increment,
  `student_id` bigint(20) NOT NULL,
  `assignment_id` bigint(20) NOT NULL,
  `package_id` bigint(20) NOT NULL,
  `question_id` bigint(20) NOT NULL,
  `answer_id` bigint(20) NOT NULL,
  `correct_answer_id` bigint(20) NOT NULL,
  `date_recorded` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `student_assmt_question` (`student_id`,`assignment_id`,`question_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `role_name` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'teacher'),
(2, 'student');

-- --------------------------------------------------------

--
-- Table structure for table `scene`
--

CREATE TABLE IF NOT EXISTS `scene` (
  `id` bigint(20) NOT NULL auto_increment,
  `tour_id` bigint(20) NOT NULL,
  `name` varchar(255) default NULL,
  `path` varchar(255) NOT NULL,
  `scene_order` int(11) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `composite` varchar(255) NOT NULL,
  `date_added` datetime default NULL,
  `flat_media` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `scene`
--

INSERT INTO `scene` (`id`, `tour_id`, `name`, `path`, `scene_order`, `thumbnail`, `composite`, `date_added`, `flat_media`) VALUES
(12, 4, 'Parking Ramp ', '01 Parking Ramp', 1, '/tour/parking-ramp/01 Parking Ramp/pano.preview.jpg', '/tour/parking-ramp/01 Parking Ramp/pano.jpg', '2013-08-21 12:01:57', 1),
(16, 5, 'Heating & Cooling Scene 1', '007', 1, '/tour/heating-cooling/007/pano.jpg', '/tour/heating-cooling/007/pano.jpg', '2014-01-20 17:48:02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(20) NOT NULL auto_increment,
  `package_id` bigint(20) NOT NULL,
  `tagname` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `id` bigint(20) NOT NULL auto_increment,
  `user_id` bigint(20) unsigned NOT NULL,
  `package_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE IF NOT EXISTS `test_results` (
  `id` bigint(20) NOT NULL auto_increment,
  `test_id` bigint(20) unsigned default NULL,
  `package_item_id` bigint(20) unsigned default NULL,
  `correct` tinyint(4) default NULL,
  `date_recorded` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE IF NOT EXISTS `tour` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `path` varchar(255) NOT NULL,
  `date_added` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tour`
--

INSERT INTO `tour` (`id`, `name`, `path`, `date_added`) VALUES
(4, 'Parking Ramp', 'parking-ramp', '2013-08-08 09:35:42'),
(5, 'Heating And Cooling', 'heating-cooling', '2014-01-20 17:43:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) collate utf8_bin NOT NULL,
  `password` varchar(255) collate utf8_bin NOT NULL,
  `email` varchar(100) collate utf8_bin NOT NULL,
  `first_name` varchar(255) collate utf8_bin NOT NULL,
  `last_name` varchar(255) collate utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL default '1',
  `banned` tinyint(1) NOT NULL default '0',
  `ban_reason` varchar(255) collate utf8_bin default NULL,
  `new_password_key` varchar(50) collate utf8_bin default NULL,
  `new_password_requested` datetime default NULL,
  `new_email` varchar(100) collate utf8_bin default NULL,
  `new_email_key` varchar(50) collate utf8_bin default NULL,
  `last_ip` varchar(40) collate utf8_bin NOT NULL,
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=67 ;



-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE IF NOT EXISTS `users_roles` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `user_id` bigint(20) unsigned default NULL,
  `role_id` bigint(20) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nodupes` (`user_id`,`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;


-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) collate utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `user_agent` varchar(150) collate utf8_bin NOT NULL,
  `last_ip` varchar(40) collate utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) collate utf8_bin default NULL,
  `website` varchar(255) collate utf8_bin default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=57 ;

--
-- Dumping data for table `user_profiles`
--



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
