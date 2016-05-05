-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-03-14 11:50:48
-- 服务器版本： 5.5.42-log
-- PHP Version: 5.4.41

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- 表的结构 `jt_ad`
--

CREATE TABLE IF NOT EXISTS `jt_ad` (
  `id` int(11) NOT NULL,
  `titile` varchar(45) NOT NULL,
  `content` varchar(150) NOT NULL,
  `url` varchar(128) NOT NULL,
  `original_path` varchar(128) NOT NULL,
  `thumb_path` varchar(45) NOT NULL,
  `createtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='几图宣传栏及广告栏';

-- --------------------------------------------------------

--
-- 表的结构 `jt_battle`
--

CREATE TABLE IF NOT EXISTS `jt_battle` (
  `id` int(11) NOT NULL COMMENT '对战ID ',
  `left_pic_id` int(11) NOT NULL COMMENT '对战图片左图ID',
  `right_pic_id` int(11) NOT NULL COMMENT '对战图片右图ID',
  `left_count` int(1) NOT NULL COMMENT '当前对战左图计数',
  `right_count` int(1) NOT NULL COMMENT '当前对战右图技术',
  `createtime` datetime NOT NULL COMMENT '对战创建时间',
  `updatetime` datetime NOT NULL COMMENT '对战更新时间',
  `isbattle` tinyint(1) NOT NULL DEFAULT '0' COMMENT '对战状态 0对战状态 1对战结束',
  `jt_theme_id` int(11) NOT NULL COMMENT '对战所属主题ID',
  `left_thumb_pic_path` varchar(128) NOT NULL,
  `left_original_pic_path` varchar(128) NOT NULL,
  `right_thumb_pic_path` varchar(128) NOT NULL,
  `right_original_pic_path` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='对战信息表';

-- --------------------------------------------------------

--
-- 表的结构 `jt_cid`
--

CREATE TABLE IF NOT EXISTS `jt_cid` (
  `id` int(11) NOT NULL,
  `cid` char(32) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='个推第三方推送ClientID与用户对应表';

--
-- 转存表中的数据 `jt_cid`
--

INSERT INTO `jt_cid` (`id`, `cid`, `uid`) VALUES
(1, '8baec61cc7dc5562330689aca54bef75', 41),
(2, '7947568bdefb07d50e38d09d0617e328', 42);

-- --------------------------------------------------------

--
-- 表的结构 `jt_code`
--

CREATE TABLE IF NOT EXISTS `jt_code` (
  `id` int(11) NOT NULL COMMENT '验证码ID',
  `code` char(32) NOT NULL COMMENT '验证码',
  `createtime` datetime NOT NULL COMMENT '验证码创建时间',
  `updatetime` datetime NOT NULL COMMENT '验证码更新时间',
  `uid` int(11) NOT NULL COMMENT '用户ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='验证码';

-- --------------------------------------------------------

--
-- 表的结构 `jt_comment`
--

CREATE TABLE IF NOT EXISTS `jt_comment` (
  `id` int(11) NOT NULL,
  `content` varchar(150) NOT NULL COMMENT '评论内容\n',
  `creatime` datetime NOT NULL COMMENT '评论创建时间\n',
  `from_uid` int(11) NOT NULL COMMENT '评论用户ID\n',
  `jt_post_pic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论表\n';

-- --------------------------------------------------------

--
-- 表的结构 `jt_death_vote`
--

CREATE TABLE IF NOT EXISTS `jt_death_vote` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `createtime` datetime NOT NULL,
  `jt_resurrection_pic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='死亡投票\n';

-- --------------------------------------------------------

--
-- 表的结构 `jt_device`
--

CREATE TABLE IF NOT EXISTS `jt_device` (
  `id` int(11) NOT NULL COMMENT '用户设备ID',
  `device_name` varchar(15) NOT NULL COMMENT '用户设备名称',
  `imei_code` varchar(15) NOT NULL COMMENT '用户设备IMEI码',
  `operating_system` varchar(20) NOT NULL COMMENT '用户设备操作系统',
  `uid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='用户设备信息保存表\n';

--
-- 转存表中的数据 `jt_device`
--

INSERT INTO `jt_device` (`id`, `device_name`, `imei_code`, `operating_system`, `uid`) VALUES
(6, 'iPhone OS', '100001049978644', '9.1', 41),
(7, 'iPhone OS', '100002815697592', '9.0', 42),
(8, 'iPhone OS', '100002815697592', '9.0', 42);

-- --------------------------------------------------------

--
-- 表的结构 `jt_follow`
--

CREATE TABLE IF NOT EXISTS `jt_follow` (
  `id` int(11) NOT NULL,
  `follow` int(11) NOT NULL COMMENT '关注用户ID',
  `fans` int(11) NOT NULL COMMENT '粉丝用户ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `jt_post_pic`
--

CREATE TABLE IF NOT EXISTS `jt_post_pic` (
  `id` int(11) NOT NULL COMMENT '图文信息ID',
  `content` varchar(150) NOT NULL COMMENT '图文信息内容',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  `thumb_pic` varchar(128) NOT NULL COMMENT '简略图路径',
  `original_pic` varchar(128) NOT NULL COMMENT '原图路径',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `jt_theme_id` int(11) NOT NULL COMMENT '图片所属主题ID',
  `isbattle` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否处于对战状态 0空闲状态，1对战状态',
  `islock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定状态，0正常状态，可以参加对战，1锁定状态，对战结束',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '图片等级，初始等级为0',
  `praise_count` int(11) NOT NULL DEFAULT '0',
  `comment_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发送图文信息表 ';

-- --------------------------------------------------------

--
-- 表的结构 `jt_resurrection_pic`
--

CREATE TABLE IF NOT EXISTS `jt_resurrection_pic` (
  `id` int(11) NOT NULL,
  `pic_id` int(11) NOT NULL COMMENT '进入复活环节图片ID',
  `resurrection_count` int(1) NOT NULL DEFAULT '0' COMMENT '投票数',
  `death_count` int(1) NOT NULL DEFAULT '0',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '更新时间',
  `isover` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否结束 0正常状态 1投票结束\n\n',
  `jt_theme_id` int(11) NOT NULL COMMENT '主题ID',
  `thumb_pic_path` varchar(128) NOT NULL,
  `original_pic_path` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='进入复活环节图片';

-- --------------------------------------------------------

--
-- 表的结构 `jt_resurrection_vote`
--

CREATE TABLE IF NOT EXISTS `jt_resurrection_vote` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '投票用户ID',
  `createtime` datetime NOT NULL COMMENT '投票时间',
  `jt_resurrection_pic_id` int(11) NOT NULL,
  `chick_id` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='复活环节投票';

-- --------------------------------------------------------

--
-- 表的结构 `jt_theme`
--

CREATE TABLE IF NOT EXISTS `jt_theme` (
  `id` int(11) NOT NULL COMMENT '图文主题ID',
  `theme` varchar(20) NOT NULL COMMENT '图文主题名',
  `content` varchar(100) NOT NULL COMMENT '图文主题描述',
  `updatetime` datetime NOT NULL COMMENT '图文主题更新日期',
  `theme_thumb_pic` varchar(128) NOT NULL COMMENT '图文主题描述简略图片路径',
  `theme_original_pic` varchar(128) NOT NULL COMMENT '图文主题描述原图路径',
  `theme_code` enum('person','food','memory','complain','alterone','altertwo') NOT NULL COMMENT '图文主题唯一标志英文\n'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='图片主题信息表\n';

--
-- 转存表中的数据 `jt_theme`
--

INSERT INTO `jt_theme` (`id`, `theme`, `content`, `updatetime`, `theme_thumb_pic`, `theme_original_pic`, `theme_code`) VALUES
(12, '个人主题20151023', '个人主题20151023描述', '2015-10-23 12:00:00', 'http://www.eddywren.com/api/images/theme/1.jpg', 'http://www.eddywren.com/api/images/theme/1.jpg', 'person'),
(13, '食物主题20151023', '食物主题20151023描述', '2015-10-23 12:00:00', 'http://www.eddywren.com/api/images/theme/2.jpg', 'http://www.eddywren.com/api/images/theme/2.jpg', 'food'),
(14, '吐槽主题20151023', '吐槽主题20151023描述', '2015-10-23 12:00:00', 'http://www.eddywren.com/api/images/theme/3.jpg', 'http://www.eddywren.com/api/images/theme/3.jpg', 'complain'),
(15, '纪念主题20151023', '纪念主题20151023描述', '2015-10-23 12:00:00', 'http://www.eddywren.com/api/images/theme/4.jpg', 'http://www.eddywren.com/api/images/theme/4.jpg', 'memory'),
(16, '可变主题一20151023', '可变主题一20151023描述', '2015-10-23 12:00:00', 'http://www.eddywren.com/api/images/theme/5.jpg', 'http://www.eddywren.com/api/images/theme/5.jpg', 'alterone'),
(17, '可变主题二20151023', '可变主题二20151023描述', '2015-10-23 12:00:00', 'http://www.eddywren.com/api/images/theme/6.jpg', 'http://www.eddywren.com/api/images/theme/6.jpg', 'altertwo');

-- --------------------------------------------------------

--
-- 表的结构 `jt_token`
--

CREATE TABLE IF NOT EXISTS `jt_token` (
  `id` int(11) NOT NULL COMMENT '令牌ID',
  `accesstoken` varchar(64) NOT NULL COMMENT '令牌码',
  `createtime` datetime NOT NULL COMMENT '令牌创建时间',
  `updatetime` datetime NOT NULL COMMENT '令牌更新时间',
  `uid` int(11) NOT NULL COMMENT '用户ID\n'
) ENGINE=InnoDB AUTO_INCREMENT=1080 DEFAULT CHARSET=utf8 COMMENT='用户访问令牌';

--
-- 转存表中的数据 `jt_token`
--

INSERT INTO `jt_token` (`id`, `accesstoken`, `createtime`, `updatetime`, `uid`) VALUES
(886, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 09:43:00', '2015-11-13 15:34:15', 41),
(887, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 09:54:52', '2015-11-13 15:34:15', 41),
(888, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 09:55:59', '2015-11-13 15:34:15', 41),
(889, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 09:58:02', '2015-11-13 15:34:15', 41),
(890, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 09:59:22', '2015-11-13 15:34:15', 41),
(891, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 09:59:46', '2015-11-13 15:34:15', 41),
(892, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:07:06', '2015-11-13 15:34:15', 41),
(893, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:08:03', '2015-11-13 15:34:15', 41),
(894, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:08:20', '2015-11-13 15:34:15', 41),
(895, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:09:47', '2015-11-13 15:34:15', 41),
(896, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:12:28', '2015-11-13 15:34:15', 41),
(897, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:13:37', '2015-11-13 15:34:15', 41),
(898, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:15:19', '2015-11-13 15:34:15', 41),
(899, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:16:54', '2015-11-13 15:34:15', 41),
(900, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:18:08', '2015-11-13 15:34:15', 41),
(901, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:20:31', '2015-11-13 15:34:15', 41),
(902, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:20:45', '2015-11-13 15:34:15', 41),
(903, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:21:46', '2015-11-13 15:34:15', 41),
(904, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:22:25', '2015-11-13 15:34:15', 41),
(905, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:22:25', '2015-11-13 15:34:15', 41),
(906, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:22:25', '2015-11-13 15:34:15', 41),
(907, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:22:44', '2015-11-13 15:34:15', 41),
(908, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:22:47', '2015-11-13 15:34:15', 41),
(909, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:23:50', '2015-11-13 15:34:15', 41),
(910, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:28:29', '2015-11-13 15:34:15', 41),
(911, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:30:15', '2015-11-13 15:34:15', 41),
(912, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:31:11', '2015-11-13 15:34:15', 41),
(913, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:32:09', '2015-11-13 15:34:15', 41),
(914, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:37:10', '2015-11-13 15:34:15', 41),
(915, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:39:00', '2015-11-13 15:34:15', 41),
(916, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:39:55', '2015-11-13 15:34:15', 41),
(917, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:43:34', '2015-11-13 15:34:15', 41),
(918, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:45:14', '2015-11-13 15:34:15', 41),
(919, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:45:24', '2015-11-13 15:34:15', 41),
(920, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:47:33', '2015-11-13 15:34:15', 41),
(921, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:48:00', '2015-11-13 15:34:15', 41),
(922, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:48:24', '2015-11-13 15:34:15', 41),
(923, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:49:23', '2015-11-13 15:34:15', 41),
(924, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:49:38', '2015-11-13 15:34:15', 41),
(925, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:54:03', '2015-11-13 15:34:15', 41),
(926, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:55:24', '2015-11-13 15:34:15', 41),
(927, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:57:47', '2015-11-13 15:34:15', 41),
(928, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:58:50', '2015-11-13 15:34:15', 41),
(929, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:59:20', '2015-11-13 15:34:15', 41),
(930, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 10:59:42', '2015-11-13 15:34:15', 41),
(931, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:02:13', '2015-11-13 15:34:15', 41),
(932, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:02:59', '2015-11-13 15:34:15', 41),
(933, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:04:59', '2015-11-13 15:34:15', 41),
(934, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:07:48', '2015-11-13 15:34:15', 41),
(935, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:16:15', '2015-11-13 15:34:15', 41),
(936, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:19:01', '2015-11-13 15:34:15', 41),
(937, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:26:47', '2015-11-13 15:34:15', 41),
(938, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:27:30', '2015-11-13 15:34:15', 41),
(939, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:30:42', '2015-11-13 15:34:15', 41),
(940, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:31:19', '2015-11-13 15:34:15', 41),
(941, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:33:04', '2015-11-13 15:34:15', 41),
(942, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:36:46', '2015-11-13 15:34:15', 41),
(943, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:38:06', '2015-11-13 15:34:15', 41),
(944, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:41:00', '2015-11-13 15:34:15', 41),
(945, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:42:34', '2015-11-13 15:34:15', 41),
(946, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:42:57', '2015-11-13 15:34:15', 41),
(947, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:46:20', '2015-11-13 15:34:15', 41),
(948, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:47:24', '2015-11-13 15:34:15', 41),
(949, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:48:46', '2015-11-13 15:34:15', 41),
(950, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:49:38', '2015-11-13 15:34:15', 41),
(951, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 11:54:16', '2015-11-13 15:34:15', 41),
(952, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 12:15:03', '2015-11-13 15:34:15', 41),
(953, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 12:31:08', '2015-11-13 15:34:15', 41),
(954, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 13:36:20', '2015-11-13 15:34:15', 41),
(955, '0d890075038ebf4eaba5a2410878b43e', '2015-11-05 13:40:24', '2015-11-05 18:38:13', 42),
(956, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 13:42:26', '2015-11-13 15:34:15', 41),
(957, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 13:52:26', '2015-11-13 15:34:15', 41),
(958, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 13:54:04', '2015-11-13 15:34:15', 41),
(959, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 13:56:16', '2015-11-13 15:34:15', 41),
(960, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 13:57:35', '2015-11-13 15:34:15', 41),
(961, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:02:00', '2015-11-13 15:34:15', 41),
(962, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:09:40', '2015-11-13 15:34:15', 41),
(963, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:13:02', '2015-11-13 15:34:15', 41),
(964, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:14:01', '2015-11-13 15:34:15', 41),
(965, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:15:37', '2015-11-13 15:34:15', 41),
(966, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:19:25', '2015-11-13 15:34:15', 41),
(967, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:19:59', '2015-11-13 15:34:15', 41),
(968, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:22:38', '2015-11-13 15:34:15', 41),
(969, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:24:30', '2015-11-13 15:34:15', 41),
(970, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:27:22', '2015-11-13 15:34:15', 41),
(971, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:29:30', '2015-11-13 15:34:15', 41),
(972, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:31:28', '2015-11-13 15:34:15', 41),
(973, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:32:30', '2015-11-13 15:34:15', 41),
(974, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:33:32', '2015-11-13 15:34:15', 41),
(975, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:36:19', '2015-11-13 15:34:15', 41),
(976, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 14:56:40', '2015-11-13 15:34:15', 41),
(977, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 15:03:34', '2015-11-13 15:34:15', 41),
(978, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 15:15:05', '2015-11-13 15:34:15', 41),
(979, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 15:23:53', '2015-11-13 15:34:15', 41),
(980, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 15:27:09', '2015-11-13 15:34:15', 41),
(981, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 16:27:43', '2015-11-13 15:34:15', 41),
(982, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 16:49:36', '2015-11-13 15:34:15', 41),
(983, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 17:55:52', '2015-11-13 15:34:15', 41),
(984, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 18:26:26', '2015-11-13 15:34:15', 41),
(985, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 18:31:24', '2015-11-13 15:34:15', 41),
(986, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 18:35:40', '2015-11-13 15:34:15', 41),
(987, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 18:37:07', '2015-11-13 15:34:15', 41),
(988, '0d890075038ebf4eaba5a2410878b43e', '2015-11-05 18:38:13', '2015-11-05 18:38:13', 42),
(989, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 18:38:32', '2015-11-13 15:34:15', 41),
(990, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 18:39:12', '2015-11-13 15:34:15', 41),
(991, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 18:39:41', '2015-11-13 15:34:15', 41),
(992, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 18:42:08', '2015-11-13 15:34:15', 41),
(993, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-05 20:29:56', '2015-11-13 15:34:15', 41),
(994, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:25:15', '2015-11-13 15:34:15', 41),
(995, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:29:52', '2015-11-13 15:34:15', 41),
(996, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:35:19', '2015-11-13 15:34:15', 41),
(997, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:37:02', '2015-11-13 15:34:15', 41),
(998, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:40:06', '2015-11-13 15:34:15', 41),
(999, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:41:11', '2015-11-13 15:34:15', 41),
(1000, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:44:11', '2015-11-13 15:34:15', 41),
(1001, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:45:42', '2015-11-13 15:34:15', 41),
(1002, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:47:27', '2015-11-13 15:34:15', 41),
(1003, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:50:53', '2015-11-13 15:34:15', 41),
(1004, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:53:33', '2015-11-13 15:34:15', 41),
(1005, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:53:52', '2015-11-13 15:34:15', 41),
(1006, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:55:01', '2015-11-13 15:34:15', 41),
(1007, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:55:28', '2015-11-13 15:34:15', 41),
(1008, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 10:55:58', '2015-11-13 15:34:15', 41),
(1009, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:00:20', '2015-11-13 15:34:15', 41),
(1010, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:02:19', '2015-11-13 15:34:15', 41),
(1011, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:03:21', '2015-11-13 15:34:15', 41),
(1012, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:05:44', '2015-11-13 15:34:15', 41),
(1013, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:08:21', '2015-11-13 15:34:15', 41),
(1014, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:10:27', '2015-11-13 15:34:15', 41),
(1015, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:11:52', '2015-11-13 15:34:15', 41),
(1016, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:13:38', '2015-11-13 15:34:15', 41),
(1017, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:15:24', '2015-11-13 15:34:15', 41),
(1018, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:17:24', '2015-11-13 15:34:15', 41),
(1019, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:17:24', '2015-11-13 15:34:15', 41),
(1020, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:17:38', '2015-11-13 15:34:15', 41),
(1021, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:18:09', '2015-11-13 15:34:15', 41),
(1022, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:20:33', '2015-11-13 15:34:15', 41),
(1023, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:23:42', '2015-11-13 15:34:15', 41),
(1024, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:31:57', '2015-11-13 15:34:15', 41),
(1025, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 11:32:59', '2015-11-13 15:34:15', 41),
(1026, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 12:10:06', '2015-11-13 15:34:15', 41),
(1027, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 12:50:56', '2015-11-13 15:34:15', 41),
(1028, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 12:56:37', '2015-11-13 15:34:15', 41),
(1029, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:00:04', '2015-11-13 15:34:15', 41),
(1030, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:05:36', '2015-11-13 15:34:15', 41),
(1031, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:11:54', '2015-11-13 15:34:15', 41),
(1032, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:12:48', '2015-11-13 15:34:15', 41),
(1033, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:14:56', '2015-11-13 15:34:15', 41),
(1034, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:15:54', '2015-11-13 15:34:15', 41),
(1035, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:34:43', '2015-11-13 15:34:15', 41),
(1036, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:47:45', '2015-11-13 15:34:15', 41),
(1037, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:51:18', '2015-11-13 15:34:15', 41),
(1038, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:52:13', '2015-11-13 15:34:15', 41),
(1039, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:52:38', '2015-11-13 15:34:15', 41),
(1040, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:57:57', '2015-11-13 15:34:15', 41),
(1041, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:58:38', '2015-11-13 15:34:15', 41),
(1042, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 13:59:27', '2015-11-13 15:34:15', 41),
(1043, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:01:13', '2015-11-13 15:34:15', 41),
(1044, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:04:08', '2015-11-13 15:34:15', 41),
(1045, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:05:40', '2015-11-13 15:34:15', 41),
(1046, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:13:36', '2015-11-13 15:34:15', 41),
(1047, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:21:01', '2015-11-13 15:34:15', 41),
(1048, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:23:34', '2015-11-13 15:34:15', 41),
(1049, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:28:46', '2015-11-13 15:34:15', 41),
(1050, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:29:12', '2015-11-13 15:34:15', 41),
(1051, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:33:26', '2015-11-13 15:34:15', 41),
(1052, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:33:47', '2015-11-13 15:34:15', 41),
(1053, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:34:17', '2015-11-13 15:34:15', 41),
(1054, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:39:24', '2015-11-13 15:34:15', 41),
(1055, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 14:49:03', '2015-11-13 15:34:15', 41),
(1056, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 15:20:20', '2015-11-13 15:34:15', 41),
(1057, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 16:00:03', '2015-11-13 15:34:15', 41),
(1058, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 16:01:19', '2015-11-13 15:34:15', 41),
(1059, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 16:03:21', '2015-11-13 15:34:15', 41),
(1060, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 16:05:33', '2015-11-13 15:34:15', 41),
(1061, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 16:05:57', '2015-11-13 15:34:15', 41),
(1062, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 17:00:19', '2015-11-13 15:34:15', 41),
(1063, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 17:01:09', '2015-11-13 15:34:15', 41),
(1064, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 17:03:37', '2015-11-13 15:34:15', 41),
(1065, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 17:05:48', '2015-11-13 15:34:15', 41),
(1066, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 17:11:33', '2015-11-13 15:34:15', 41),
(1067, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 17:14:42', '2015-11-13 15:34:15', 41),
(1068, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 17:17:06', '2015-11-13 15:34:15', 41),
(1069, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 17:19:25', '2015-11-13 15:34:15', 41),
(1070, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 17:21:29', '2015-11-13 15:34:15', 41),
(1071, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 18:23:01', '2015-11-13 15:34:15', 41),
(1072, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-06 21:57:42', '2015-11-13 15:34:15', 41),
(1073, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-11 14:23:25', '2015-11-13 15:34:15', 41),
(1074, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-12 15:48:03', '2015-11-13 15:34:15', 41),
(1075, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-12 15:48:51', '2015-11-13 15:34:15', 41),
(1076, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-12 15:50:09', '2015-11-13 15:34:15', 41),
(1077, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-12 15:50:09', '2015-11-13 15:34:15', 41),
(1078, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-12 15:50:17', '2015-11-13 15:34:15', 41),
(1079, '57f87aa2b2d7107eda30611d4f32d679', '2015-11-13 15:34:15', '2015-11-13 15:34:15', 41);

-- --------------------------------------------------------

--
-- 表的结构 `jt_user`
--

CREATE TABLE IF NOT EXISTS `jt_user` (
  `id` int(11) NOT NULL COMMENT '用户ID',
  `username` char(11) NOT NULL COMMENT '用户账号',
  `encrypted_password` varchar(64) NOT NULL COMMENT '用户密码（已加密）',
  `salt` varchar(11) NOT NULL COMMENT '加密盐值',
  `islock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户是否锁定：0正常状态，1锁定状态',
  `createtime` datetime NOT NULL COMMENT '用户创建时间',
  `updatetime` datetime NOT NULL COMMENT '用户更新时间'
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `jt_user`
--

INSERT INTO `jt_user` (`id`, `username`, `encrypted_password`, `salt`, `islock`, `createtime`, `updatetime`) VALUES
(40, '1234', '9t5sx3RvVvvCwnch1nPuuP2qTFFiZTEzYmVjY2Fh', 'be13beccaa', 0, '2015-10-23 09:46:08', '2015-10-23 09:46:08'),
(41, '1', '1xkwtbzaZyQNXJQ7Sp2MU/5d9KhhYjRiM2Y0Y2Uw', 'ab4b3f4ce0', 0, '2015-10-23 10:14:32', '2015-11-13 15:34:15'),
(42, '123', 'GVaw4SFgLAY6PGy40uEDrdwkxJ8xNDY4N2ZkMjVj', '14687fd25c', 0, '2015-10-25 16:27:43', '2015-11-05 18:38:13'),
(43, '12345', 'sXgq+21+EaZnVtZRSLn/+l+zSms4YjBjN2NmMmY0', '8b0c7cf2f4', 0, '2015-10-25 19:47:35', '2015-10-25 19:47:35'),
(44, '111', 'PpEGpn1DiaELbDz8Y/UXpinn+CZiYzYzNjFlZjdh', 'bc6361ef7a', 0, '2015-11-11 10:31:27', '2015-11-11 10:31:27');

-- --------------------------------------------------------

--
-- 表的结构 `jt_userinfo`
--

CREATE TABLE IF NOT EXISTS `jt_userinfo` (
  `id` int(11) NOT NULL COMMENT '用户信息ID',
  `nickname` varchar(20) NOT NULL COMMENT '用户昵称',
  `sex` enum('男','女') NOT NULL DEFAULT '男' COMMENT '用户性别',
  `age` int(3) NOT NULL COMMENT '用户年龄\n',
  `birthday` date NOT NULL COMMENT '用户生日',
  `location_province` varchar(5) NOT NULL COMMENT '用户所在地区',
  `location_city` varchar(10) NOT NULL,
  `bloodtype` varchar(3) NOT NULL COMMENT '用户血型',
  `email` varchar(25) NOT NULL COMMENT '用户邮箱',
  `graduation` varchar(15) NOT NULL COMMENT '用户毕业院校',
  `follow` int(11) NOT NULL COMMENT '用户关注数',
  `fans` int(11) NOT NULL COMMENT '用户粉丝数',
  `intro` varchar(26) NOT NULL COMMENT '用户个性签名',
  `head_pic_path` varchar(128) NOT NULL COMMENT '用户头像路径',
  `background_pic_path` varchar(128) NOT NULL COMMENT '个人背景图片路径',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `chick_id` int(11) NOT NULL COMMENT '专属鸡ID',
  `createtime` datetime NOT NULL,
  `updatetime` datetime NOT NULL COMMENT '用户信息更新时间'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='用户信息表\n';

--
-- 转存表中的数据 `jt_userinfo`
--

INSERT INTO `jt_userinfo` (`id`, `nickname`, `sex`, `age`, `birthday`, `location_province`, `location_city`, `bloodtype`, `email`, `graduation`, `follow`, `fans`, `intro`, `head_pic_path`, `background_pic_path`, `uid`, `chick_id`, `createtime`, `updatetime`) VALUES
(4, '1234', '男', 100, '2015-10-23', '北京', '朝阳', 'O型', '', '', 0, 0, '', '', '', 40, 0, '2015-10-23 09:46:08', '2015-10-23 09:46:08'),
(5, '路飞', '男', 100, '2015-10-23', '北京', '朝阳', 'O型', '', '', 8, 1025, '我是要成为海贼王的男人', '/home/wwwroot/www.eddywren.com/api/images/headpic/1.jpg', '', 41, 0, '2015-10-23 10:14:32', '2015-10-29 17:31:19'),
(6, '123', '男', 100, '2015-10-25', '北京', '朝阳', 'O型', '', '', 123, 23495, '兰尼斯特有债必偿', '/home/wwwroot/www.eddywren.com/api/images/headpic/123.jpg', '', 42, 0, '2015-10-25 16:27:43', '2015-10-28 17:53:27'),
(7, '12345', '男', 100, '2015-10-25', '北京', '朝阳', 'O型', '', '', 0, 0, '', '', '', 43, 0, '2015-10-25 19:47:35', '2015-10-25 19:47:35'),
(8, '111', '男', 100, '2015-11-11', '北京', '朝阳', 'O型', '', '', 0, 0, '', '', '', 44, 0, '2015-11-11 10:31:27', '2015-11-11 10:31:27');

-- --------------------------------------------------------

--
-- 表的结构 `jt_vote`
--

CREATE TABLE IF NOT EXISTS `jt_vote` (
  `id` int(11) NOT NULL COMMENT '投票ID\n',
  `pic_id` int(11) NOT NULL COMMENT '投票图片ID',
  `uid` int(11) NOT NULL COMMENT '投票用户ID\n',
  `createtime` datetime NOT NULL COMMENT '投票时间\n',
  `jt_battle_id` int(11) NOT NULL COMMENT '所属对战ID\n',
  `chick_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投票信息表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jt_ad`
--
ALTER TABLE `jt_ad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jt_battle`
--
ALTER TABLE `jt_battle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_jt_battle_jt_theme1_idx` (`jt_theme_id`);

--
-- Indexes for table `jt_cid`
--
ALTER TABLE `jt_cid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `jt_code`
--
ALTER TABLE `jt_code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `jt_comment`
--
ALTER TABLE `jt_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jt_comment_jt_post_pic1_idx` (`jt_post_pic_id`);

--
-- Indexes for table `jt_death_vote`
--
ALTER TABLE `jt_death_vote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_table1_jt_resurrection_pic1_idx` (`jt_resurrection_pic_id`);

--
-- Indexes for table `jt_device`
--
ALTER TABLE `jt_device`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `jt_follow`
--
ALTER TABLE `jt_follow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follow` (`follow`),
  ADD KEY `fans` (`fans`);

--
-- Indexes for table `jt_post_pic`
--
ALTER TABLE `jt_post_pic`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_jt_post_pic_jt_user1_idx` (`uid`),
  ADD KEY `fk_jt_post_pic_jt_theme1_idx` (`jt_theme_id`);

--
-- Indexes for table `jt_resurrection_pic`
--
ALTER TABLE `jt_resurrection_pic`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_jt_resurrection_pic_jt_theme1_idx` (`jt_theme_id`);

--
-- Indexes for table `jt_resurrection_vote`
--
ALTER TABLE `jt_resurrection_vote`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_jt_resurrection_vote_jt_resurrection_pic1_idx` (`jt_resurrection_pic_id`);

--
-- Indexes for table `jt_theme`
--
ALTER TABLE `jt_theme`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `jt_token`
--
ALTER TABLE `jt_token`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `jt_user`
--
ALTER TABLE `jt_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `jt_userinfo`
--
ALTER TABLE `jt_userinfo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `jt_vote`
--
ALTER TABLE `jt_vote`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_jt_vote_jt_battle1_idx` (`jt_battle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jt_ad`
--
ALTER TABLE `jt_ad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jt_battle`
--
ALTER TABLE `jt_battle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '对战ID ';
--
-- AUTO_INCREMENT for table `jt_cid`
--
ALTER TABLE `jt_cid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jt_code`
--
ALTER TABLE `jt_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '验证码ID';
--
-- AUTO_INCREMENT for table `jt_comment`
--
ALTER TABLE `jt_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jt_death_vote`
--
ALTER TABLE `jt_death_vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jt_device`
--
ALTER TABLE `jt_device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户设备ID',AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `jt_follow`
--
ALTER TABLE `jt_follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jt_post_pic`
--
ALTER TABLE `jt_post_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图文信息ID';
--
-- AUTO_INCREMENT for table `jt_resurrection_vote`
--
ALTER TABLE `jt_resurrection_vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jt_theme`
--
ALTER TABLE `jt_theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图文主题ID',AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `jt_token`
--
ALTER TABLE `jt_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '令牌ID',AUTO_INCREMENT=1080;
--
-- AUTO_INCREMENT for table `jt_user`
--
ALTER TABLE `jt_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `jt_userinfo`
--
ALTER TABLE `jt_userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户信息ID',AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `jt_vote`
--
ALTER TABLE `jt_vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '投票ID\n';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
