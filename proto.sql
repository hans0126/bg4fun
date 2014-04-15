-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 10 月 28 日 05:13
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `proto`
--

-- --------------------------------------------------------

--
-- 表的结构 `it_sessions`
--

CREATE TABLE IF NOT EXISTS `it_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `it_sessions`
--

INSERT INTO `it_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('33bfdf00e30ac87e5a11a2a7881a9a9d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', 1382930926, 'a:8:{s:9:"user_data";s:0:"";s:12:"admin_accept";i:1;s:8:"admin_sn";s:1:"1";s:8:"admin_id";s:5:"admin";s:11:"admin_email";s:20:"claire@akacia.com.tw";s:12:"supper_admin";s:1:"1";s:16:"admin_login_time";s:19:"2013-10-28 11:32:01";s:10:"admin_auth";a:13:{i:0;s:2:"22";i:1;s:2:"24";i:2;s:2:"26";i:3;s:2:"28";i:4;s:2:"30";i:5;s:2:"31";i:6;s:2:"32";i:7;s:2:"33";i:8;s:2:"35";i:9;s:2:"36";i:10;s:2:"37";i:11;s:2:"38";i:12;s:2:"39";}}');

-- --------------------------------------------------------

--
-- 表的结构 `sys_admin`
--

CREATE TABLE IF NOT EXISTS `sys_admin` (
  `sn` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pw` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `forever` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `launch` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `is_default` tinyint(4) NOT NULL DEFAULT '0',
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `sys_admin`
--

INSERT INTO `sys_admin` (`sn`, `id`, `pw`, `email`, `start_date`, `end_date`, `forever`, `launch`, `is_default`, `update_date`) VALUES
(1, 'admin', 'f36164e122fe1b2b93543fc0f5504f5bea1d7278', 'claire@akacia.com.tw', '2012-05-03 00:00:00', '2012-06-06 00:00:00', 1, 1, 1, '2013-10-24 17:00:25'),
(6, 'test', '5ac71276b251c1f4e0bb2df2dfce94539fad58cc', '', '2013-10-28 00:00:00', NULL, 1, 1, 0, '2013-10-28 10:59:56');

-- --------------------------------------------------------

--
-- 表的结构 `sys_admin_belong_group`
--

CREATE TABLE IF NOT EXISTS `sys_admin_belong_group` (
  `sys_admin_sn` int(10) unsigned NOT NULL,
  `sys_admin_group_sn` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `FK_sys_admin_belong_group_1` (`sys_admin_sn`),
  KEY `FK_sys_admin_belong_group_2` (`sys_admin_group_sn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sys_admin_belong_group`
--

INSERT INTO `sys_admin_belong_group` (`sys_admin_sn`, `sys_admin_group_sn`) VALUES
(1, 2),
(6, 3);

-- --------------------------------------------------------

--
-- 表的结构 `sys_admin_group`
--

CREATE TABLE IF NOT EXISTS `sys_admin_group` (
  `sn` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `accept_authority` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `delete_authority` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `avail_language_sn` int(10) unsigned NOT NULL DEFAULT '1',
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `sys_admin_group`
--

INSERT INTO `sys_admin_group` (`sn`, `name`, `is_default`, `accept_authority`, `delete_authority`, `avail_language_sn`, `update_date`) VALUES
(2, '最高權限', 0, 1, 0, 1, '2013-10-24 17:12:33'),
(3, 'test', 0, 0, 0, 1, '2013-10-28 09:44:17');

-- --------------------------------------------------------

--
-- 表的结构 `sys_admin_group_authority`
--

CREATE TABLE IF NOT EXISTS `sys_admin_group_authority` (
  `sn` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_admin_group_sn` int(10) unsigned NOT NULL DEFAULT '0',
  `module_sn` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sn`),
  KEY `FK_sys_admin_group_authority_1` (`sys_admin_group_sn`),
  KEY `FK_sys_admin_group_authority_2` (`module_sn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;

--
-- 转存表中的数据 `sys_admin_group_authority`
--

INSERT INTO `sys_admin_group_authority` (`sn`, `sys_admin_group_sn`, `module_sn`) VALUES
(52, 2, 30),
(53, 2, 24),
(54, 2, 26),
(55, 2, 33),
(56, 2, 36),
(57, 2, 37),
(58, 2, 31),
(59, 2, 38),
(60, 2, 35),
(62, 3, 26),
(63, 3, 28),
(64, 3, 22),
(65, 3, 37);

-- --------------------------------------------------------

--
-- 表的结构 `sys_avail_language`
--

CREATE TABLE IF NOT EXISTS `sys_avail_language` (
  `sn` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `region_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `language_value` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(10) NOT NULL DEFAULT '500',
  `is_default` tinyint(3) NOT NULL DEFAULT '0',
  `launch` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `sys_avail_language`
--

INSERT INTO `sys_avail_language` (`sn`, `language_name`, `region_name`, `language_value`, `sort`, `is_default`, `launch`) VALUES
(1, '英文', '', 'en-global', 1, 1, 1),
(2, '中文', '', 'zh-tw', 500, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `sys_language_word`
--

CREATE TABLE IF NOT EXISTS `sys_language_word` (
  `sn` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `value_name` varchar(50) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '1:常用 2:系統',
  PRIMARY KEY (`sn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `sys_language_word`
--

INSERT INTO `sys_language_word` (`sn`, `title`, `value_name`, `type`) VALUES
(31, '汽車', 'car', 0),
(32, '香蕉', 'banana', 0),
(33, '紙', 'paper', 0);

-- --------------------------------------------------------

--
-- 表的结构 `sys_language_word_detail`
--

CREATE TABLE IF NOT EXISTS `sys_language_word_detail` (
  `sn` int(11) NOT NULL AUTO_INCREMENT,
  `avail_language_sn` int(10) unsigned NOT NULL,
  `language_word_sn` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sn`),
  KEY `avail_language_sn` (`avail_language_sn`),
  KEY `language_word_sn` (`language_word_sn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `sys_language_word_detail`
--

INSERT INTO `sys_language_word_detail` (`sn`, `avail_language_sn`, `language_word_sn`, `title`) VALUES
(31, 1, 32, 'banana'),
(32, 1, 31, 'car'),
(33, 1, 33, 'paper');

-- --------------------------------------------------------

--
-- 表的结构 `sys_module`
--

CREATE TABLE IF NOT EXISTS `sys_module` (
  `sn` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_category_sn` int(10) unsigned NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '500',
  `launch` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `avail_language_sn` int(10) unsigned DEFAULT '1',
  PRIMARY KEY (`sn`),
  KEY `avail_language_sn` (`avail_language_sn`),
  KEY `module_category_sn` (`module_category_sn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- 转存表中的数据 `sys_module`
--

INSERT INTO `sys_module` (`sn`, `id`, `module_category_sn`, `title`, `sort`, `launch`, `avail_language_sn`) VALUES
(22, 'auth', 1, '權限管理', 999, 1, 1),
(24, 'page', 1, '文章管理', 500, 1, 1),
(26, 'media', 1, '媒體庫', 500, 1, 1),
(28, 'banner', 1, 'Banner', 500, 1, 1),
(30, 'setting', 1, '網站設定', 5, 1, 1),
(31, 'homesetting', 1, '首頁設定', 500, 1, 2),
(32, 'news', 1, '最新消息', 500, 1, 1),
(33, 'product', 1, '產品管理', 500, 1, 1),
(35, 'module', 2, '模組管理', 500, 1, 1),
(36, 'auth', 1, '權限管理', 1, 1, 2),
(37, 'setting', 1, '網站設定', 1, 1, 2),
(38, 'language', 2, '語系管理', 0, 1, 1),
(39, 'auth', 1, '權限管理', 1, 1, 3);

-- --------------------------------------------------------

--
-- 表的结构 `sys_module_category`
--

CREATE TABLE IF NOT EXISTS `sys_module_category` (
  `sn` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(10) NOT NULL DEFAULT '500',
  `avail_language_sn` int(10) unsigned NOT NULL,
  `launch` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sn`),
  KEY `avail_language_sn` (`avail_language_sn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `sys_module_category`
--

INSERT INTO `sys_module_category` (`sn`, `title`, `sort`, `avail_language_sn`, `launch`) VALUES
(1, '一般機制', 40, 1, 1),
(2, '網站核心', 500, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `sys_setting`
--

CREATE TABLE IF NOT EXISTS `sys_setting` (
  `sn` int(11) NOT NULL AUTO_INCREMENT,
  `meta_keyword` text COLLATE utf8_unicode_ci,
  `meta_description` text COLLATE utf8_unicode_ci,
  `website_title` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sys_setting`
--

INSERT INTO `sys_setting` (`sn`, `meta_keyword`, `meta_description`, `website_title`, `update_date`) VALUES
(1, '', '', '', '2013-10-12 21:56:05');

--
-- 限制导出的表
--

--
-- 限制表 `sys_admin_belong_group`
--
ALTER TABLE `sys_admin_belong_group`
  ADD CONSTRAINT `sys_admin_belong_group_ibfk_1` FOREIGN KEY (`sys_admin_sn`) REFERENCES `sys_admin` (`sn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sys_admin_belong_group_ibfk_2` FOREIGN KEY (`sys_admin_group_sn`) REFERENCES `sys_admin_group` (`sn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `sys_language_word_detail`
--
ALTER TABLE `sys_language_word_detail`
  ADD CONSTRAINT `sys_language_word_detail_ibfk_1` FOREIGN KEY (`avail_language_sn`) REFERENCES `sys_avail_language` (`sn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sys_language_word_detail_ibfk_2` FOREIGN KEY (`language_word_sn`) REFERENCES `sys_language_word` (`sn`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
