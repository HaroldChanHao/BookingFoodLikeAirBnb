-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-09-25 13:48:52
-- 服务器版本： 5.6.40-log
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mealmir`
--
DROP DATABASE IF EXISTS `mealmir`;
CREATE DATABASE IF NOT EXISTS `mealmir` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mealmir`;

-- --------------------------------------------------------

--
-- 表的结构 `mealmir_about`
--

DROP TABLE IF EXISTS `mealmir_about`;
CREATE TABLE IF NOT EXISTS `mealmir_about` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `news_content` text NOT NULL,
  `news_create` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mealmir_activity`
--

DROP TABLE IF EXISTS `mealmir_activity`;
CREATE TABLE IF NOT EXISTS `mealmir_activity` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `act_name` varchar(255) DEFAULT NULL COMMENT '活动名称',
  `act_location` int(10) UNSIGNED NOT NULL COMMENT '活动地点',
  `act_add` varchar(255) NOT NULL COMMENT '活动地址',
  `act_lat` varchar(255) DEFAULT NULL,
  `act_lng` varchar(255) DEFAULT NULL,
  `act_class` int(10) UNSIGNED DEFAULT NULL COMMENT '活动类别',
  `act_images` longtext COMMENT '活动封面图',
  `act_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `act_date_start` datetime NOT NULL COMMENT '活动举办开始时间',
  `act_date_end` datetime NOT NULL COMMENT '活动结束时间',
  `act_desc` longtext COMMENT '活动内容',
  `act_contact` varchar(255) DEFAULT NULL COMMENT '活动联系信息',
  `act_status` int(11) DEFAULT '0' COMMENT '活动状态，0，待审核；1，待结单；2，已结束；3，删除待审核',
  `act_user` int(11) NOT NULL COMMENT '活动发起用户',
  `act_total` int(11) NOT NULL DEFAULT '1' COMMENT '活动总人数',
  `act_ord_start` datetime NOT NULL COMMENT '预订开始时间',
  `act_ord_end` datetime NOT NULL COMMENT '预订结束时间',
  `del_sign` int(11) NOT NULL DEFAULT '0' COMMENT '是否申请删除，1是删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mealmir_admin`
--

DROP TABLE IF EXISTS `mealmir_admin`;
CREATE TABLE IF NOT EXISTS `mealmir_admin` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) NOT NULL COMMENT '用户手机',
  `user_password` char(32) NOT NULL COMMENT '用户密码\n',
  `user_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '用户创建时间戳\n',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_mobile_UNIQUE` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台管理用户';

-- --------------------------------------------------------

--
-- 表的结构 `mealmir_city`
--

DROP TABLE IF EXISTS `mealmir_city`;
CREATE TABLE IF NOT EXISTS `mealmir_city` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_name` varchar(255) NOT NULL,
  `con_name` varchar(255) NOT NULL,
  `city_pic` varchar(255) DEFAULT NULL,
  `city_create` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mealmir_class`
--

DROP TABLE IF EXISTS `mealmir_class`;
CREATE TABLE IF NOT EXISTS `mealmir_class` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `class_title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mealmir_comment`
--

DROP TABLE IF EXISTS `mealmir_comment`;
CREATE TABLE IF NOT EXISTS `mealmir_comment` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `act_id` int(10) UNSIGNED NOT NULL COMMENT '活动id',
  `com_user` int(10) UNSIGNED NOT NULL COMMENT '评价人',
  `com_content` text COMMENT '评价内容',
  `com_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `com_status` int(11) DEFAULT '0' COMMENT '评价状态，0，审核中，1审核通过',
  `act_user` int(10) UNSIGNED NOT NULL COMMENT '被评价人',
  `star_val` int(10) UNSIGNED NOT NULL COMMENT '评价星数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mealmir_letter`
--

DROP TABLE IF EXISTS `mealmir_letter`;
CREATE TABLE IF NOT EXISTS `mealmir_letter` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `odr_id` int(10) UNSIGNED NOT NULL COMMENT '订单id',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '收信方id',
  `post_id` int(10) UNSIGNED NOT NULL COMMENT '发信方id',
  `letter_con` text NOT NULL COMMENT '消息内容',
  `letter_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '消息创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='内部通信';

-- --------------------------------------------------------

--
-- 表的结构 `mealmir_news`
--

DROP TABLE IF EXISTS `mealmir_news`;
CREATE TABLE IF NOT EXISTS `mealmir_news` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `news_title` varchar(255) NOT NULL,
  `news_content` longtext NOT NULL,
  `news_pic` varchar(255) DEFAULT NULL,
  `news_create` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mealmir_order`
--

DROP TABLE IF EXISTS `mealmir_order`;
CREATE TABLE IF NOT EXISTS `mealmir_order` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `act_id` int(10) UNSIGNED NOT NULL COMMENT '活动id',
  `order_user` int(10) UNSIGNED NOT NULL COMMENT '订单用户',
  `order_number` int(11) NOT NULL DEFAULT '1' COMMENT '订单人数',
  `order_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status` int(11) NOT NULL DEFAULT '0' COMMENT '0，进行中，1，已结束',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mealmir_subscribe`
--

DROP TABLE IF EXISTS `mealmir_subscribe`;
CREATE TABLE IF NOT EXISTS `mealmir_subscribe` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sub_user` int(11) NOT NULL COMMENT '订阅者id',
  `act_user` int(11) NOT NULL COMMENT '被订阅者id',
  `sub_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '订阅时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mealmir_user`
--

DROP TABLE IF EXISTS `mealmir_user`;
CREATE TABLE IF NOT EXISTS `mealmir_user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL COMMENT '用户手机',
  `user_name` varchar(45) DEFAULT NULL,
  `user_password` char(32) NOT NULL COMMENT '用户密码\n',
  `user_ location` varchar(255) DEFAULT NULL COMMENT '用户省份\n',
  `user_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '用户创建时间',
  `user_pic` varchar(255) DEFAULT 'user.png' COMMENT '用户头像',
  `user_openid` char(32) DEFAULT NULL COMMENT '用户微信openid\n',
  `user_status` char(1) NOT NULL DEFAULT '0' COMMENT '用户状态，0正常，1禁用',
  `user_verify` char(1) NOT NULL DEFAULT '0' COMMENT '邮箱验证，0，未验证，1已验证',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_mobile_UNIQUE` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
