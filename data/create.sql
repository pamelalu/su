-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2013 at 01:02 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `su`
--

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `person_age` int(3) NOT NULL,
  `person_gender` varchar(10) NOT NULL,
  `person_city` varchar(200) NOT NULL,
  `person_state` varchar(200) NOT NULL,
  `person_country` varchar(200) NOT NULL,
  `person_rating` int(3) NOT NULL,
  `person_source` varchar(40) NOT NULL,
  `person_timestamp` datetime NOT NULL,
  PRIMARY KEY (`person_id`),
  KEY `person_age` (`person_age`,`person_gender`),
  KEY `person_gender` (`person_gender`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `person_tags`
--

CREATE TABLE `person_tags` (
  `pt_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `tag_name` varchar(200) NOT NULL,
  `tag_count` int(11) NOT NULL,
  `pt_source` varchar(40) NOT NULL,
  PRIMARY KEY (`pt_id`),
  KEY `person_id` (`person_id`,`tag_name`),
  KEY `tag_name` (`tag_name`),
  KEY `tag_count` (`tag_count`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
