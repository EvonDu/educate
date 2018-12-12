-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-12-12 09:53:32
-- 服务器版本： 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `educate`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'ULwygLX7XnxBS9CXpAzSM1jgNGGorbTV', '$2y$13$Ub4mxQwC13OyToOju5IdyecrQhBS8w89FSlR5B0NWQIjopLizSe1S', NULL, 'admin@yii.com', 10, 1534902242, 1534902242);

-- --------------------------------------------------------

--
-- 表的结构 `admin_info`
--

CREATE TABLE `admin_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nickname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `admin_info`
--

INSERT INTO `admin_info` (`id`, `user_id`, `nickname`, `avatar`, `phone`) VALUES
(1, 1, '管理员', 'http://pdt1od3ni.bkt.clouddn.com//5bb85767d2e97.jpg', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL COMMENT '聚集索引',
  `num` varchar(50) NOT NULL COMMENT '课程号',
  `type_id` int(11) DEFAULT NULL COMMENT '课程类型',
  `instructor_id` int(11) DEFAULT NULL COMMENT '课程导师',
  `price` int(11) NOT NULL DEFAULT '0' COMMENT '课程价格',
  `name` varchar(50) DEFAULT NULL COMMENT '课程名称',
  `image` varchar(256) DEFAULT NULL COMMENT '课程封面',
  `level` int(11) DEFAULT NULL COMMENT '课程难度',
  `period` int(11) NOT NULL DEFAULT '0' COMMENT '课程课时',
  `synopsis` text COMMENT '课程摘要',
  `abstract` text COMMENT '课程简介',
  `requirements_prerequisites` text COMMENT '前提',
  `requirements_textbooks` text COMMENT '教科书',
  `requirements_software` text COMMENT '软件要求',
  `requirements_hardware` text COMMENT '硬件要求',
  `try` bit(1) DEFAULT b'0' COMMENT '支持试用',
  `try_day` int(11) DEFAULT '0' COMMENT '试用天数',
  `next_term_at` int(11) DEFAULT '0' COMMENT '下学期',
  `created_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`id`, `num`, `type_id`, `instructor_id`, `price`, `name`, `image`, `level`, `period`, `synopsis`, `abstract`, `requirements_prerequisites`, `requirements_textbooks`, `requirements_software`, `requirements_hardware`, `try`, `try_day`, `next_term_at`, `created_at`, `updated_at`) VALUES
(2, 'YII001', 2, 1, 0, 'Yii 2.0 权威指南', 'http://pdt1od3ni.bkt.clouddn.com/course/5bb813e766f38.jpg', 1, 28, '我是摘要', '<h2>系统要求和先决条件 <span id=""></span></h2><p>Yii 2.0 需要 PHP 5.4.0 或以上版本支持。你可以通过运行任何\r\nYii 发行包中附带的系统要求检查器查看每个具体特性所需的 PHP 配置。</p><p>使用 Yii 需要对面向对象编程（OOP）有基本了解，因为 Yii 是一个纯面向对象的框架。Yii 2.0 还使用了 PHP 的最新特性，\r\n例如<a href="http://www.php.net/manual/en/language.namespaces.php">命名空间</a>\r\n和<a href="http://www.php.net/manual/en/language.oop5.traits.php">Trait（特质）</a>。\r\n理解这些概念将有助于你更快地掌握 Yii 2.0。</p>', NULL, NULL, NULL, NULL, b'1', 30, 1538409600, 0, 1543039680),
(3, 'MySql001', 2, 1, 0, 'MySql 从入门到删库', NULL, 2, 32, NULL, 'rm -rf / 真刺激', NULL, NULL, NULL, NULL, b'0', 30, 0, 1539003884, 1539004469),
(4, 'num001', 2, 1, 0, 'IT售前工程师修炼之道', NULL, 1, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'1', 30, 0, 1542026900, 1543313120),
(5, 'num002', 2, 1, 0, 'IT工程师修炼之道', NULL, 1, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542026941, 1542026941),
(6, 'num003', 2, 2, 0, 'IT售前工程师', NULL, 2, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542026987, 1542026987),
(7, 'num004', 3, 1, 0, 'IT售前之道', NULL, 2, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027015, 1542027015),
(8, 'num005', 2, 1, 0, 'IT售前工程师修炼', NULL, 5, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027044, 1542027044),
(9, 'num006', 3, 1, 0, 'IT项目管理（英文精编版 第7版）', NULL, 4, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027076, 1542027076),
(10, 'num007', 2, 2, 0, 'IT项目管理', NULL, 5, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027113, 1542027113),
(11, 'num008', 3, 1, 0, 'IT项目', NULL, 5, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027136, 1542027136),
(12, 'num009', 2, 2, 0, 'PHP从入门到精通', NULL, 5, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027175, 1542027175),
(13, 'num010', 2, 1, 0, 'PHP从入门到放弃', NULL, 1, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027203, 1542027203),
(14, 'num011', 2, 2, 0, ' PHP核心技术与最佳实践', NULL, 3, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027244, 1542027244),
(15, 'num012', 2, 2, 0, ' PHP核心技术', NULL, 1, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027275, 1542027275),
(16, 'num013', 3, 2, 0, ' PHP最佳实践', NULL, 2, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027305, 1542027305),
(17, 'num014', 2, 2, 0, 'PHP开发实例大全', NULL, 5, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027335, 1542027335),
(18, 'num015', 2, 1, 0, 'PHP开发实例', NULL, 5, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027356, 1542027356),
(19, 'num016', 2, 1, 0, 'PHP、MySQL与JavaScript学习手册', NULL, 5, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027393, 1542027393),
(20, 'num017', 3, 1, 0, 'PHP、MySQL学习手册', NULL, 5, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027421, 1542027421),
(21, 'num018', 2, 1, 0, 'PHP与JavaScript学习手册', NULL, 5, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027450, 1542027450),
(22, 'num019', 41, 1, 0, 'PHP学习手册', NULL, 5, 32, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 0, 1542027493, 1542027493),
(23, 'P1', 2, 2, 0, 'I-LINK Pahonics', NULL, 2, 10, '摘要摘要摘要摘要摘要摘要摘要摘要摘要摘要', '<span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">简介</span>', '<span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 前</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 前</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 前</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 前</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 前</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 前</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 前</span>', '<span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 教材</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 教材</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 教材</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 教材</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 教材</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 教材</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 教材</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 教材</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 教材</span>', '<span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 软件</span>', '<span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 硬件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 硬件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 硬件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 硬件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 硬件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 硬件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 硬件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 硬件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 硬件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 硬件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 硬件</span><span style="color: rgb(96, 98, 102); font-weight: 700; text-align: right;">课程要求 - 硬件</span>', b'1', 7, 0, 1543672878, 1543673028);

-- --------------------------------------------------------

--
-- 表的结构 `course_lesson`
--

CREATE TABLE `course_lesson` (
  `id` int(11) NOT NULL COMMENT '聚集索引',
  `course_id` int(11) NOT NULL COMMENT '课程ID',
  `lesson` int(11) NOT NULL DEFAULT '0' COMMENT '课号',
  `title` varchar(120) NOT NULL COMMENT '标题',
  `abstract` text COMMENT '简介',
  `video` varchar(256) DEFAULT NULL COMMENT '视频',
  `content` text COMMENT '内容',
  `task` text COMMENT '作业',
  `try` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否试用',
  `free` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否免费'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `course_lesson`
--

INSERT INTO `course_lesson` (`id`, `course_id`, `lesson`, `title`, `abstract`, `video`, `content`, `task`, `try`, `free`) VALUES
(6, 2, 1, '关于 Yii（About Yii）', '<h1 id="yii">Yii 是什么 <a href="https://www.yiichina.com/doc/guide/2.0/intro-yii#yii" class="hashlink">¶</a></h1><p>Yii 是一个高性能，基于组件的 PHP 框架，用于快速开发现代 Web 应用程序。\r\n名字 Yii （读作 <code>易</code>）在中文里有“极致简单与不断演变”两重含义，\r\n也可看作 <strong>Yes It Is</strong>! 的缩写。</p><h2 id="yii">Yii 最适合做什么？ </h2><p>Yii 是一个通用的 Web 编程框架，即可以用于开发各种用 PHP 构建的 Web 应用。\r\n因为基于组件的框架结构和设计精巧的缓存支持，它特别适合开发大型应用，\r\n如门户网站、社区、内容管理系统（CMS）、\r\n电子商务项目和 RESTful Web 服务等。</p>', 'http://pdt1od3ni.bkt.clouddn.com/video/5bb816db2e9d0.webm', 'Yii 不是一场独角戏，它由一个强大的开发者团队提供支持， 也有一个庞大的专家社区，持续不断地对 Yii 的开发作出贡献。 Yii 开发者团队始终对 Web 开发趋势和其他框架及项目中的最佳实践和特性保持密切关注， 那些有意义的最佳实践及特性会被不定期的整合进核心框架中， 并提供简单优雅的接口。', '<h2>系统要求和先决条件 <span id=""></span></h2><p>Yii 2.0 需要 PHP 5.4.0 或以上版本支持。你可以通过运行任何\r\nYii 发行包中附带的系统要求检查器查看每个具体特性所需的 PHP 配置。</p>\r\n<p>使用 Yii 需要对面向对象编程（OOP）有基本了解，因为 Yii 是一个纯面向对象的框架。Yii 2.0 还使用了 PHP 的最新特性，\r\n例如<a href="http://www.php.net/manual/en/language.namespaces.php">命名空间</a>\r\n和<a href="http://www.php.net/manual/en/language.oop5.traits.php">Trait（特质）</a>。\r\n理解这些概念将有助于你更快地掌握 Yii 2.0。</p>', b'1', b'1'),
(7, 2, 2, '测试章节', '<span style="color: rgb(34, 34, 34); font-family: tahoma, arial, &quot;Microsoft YaHei&quot;;">nice PHP内置函数memory_get_usage()能返回当前分配给PHP脚本的内存量，单位是字节（byte）。在WEB实际开发中，这些函数非常有用，我们可以使用它来调试PHP代码性能。</span><br style="color: rgb(34, 34, 34); font-family: tahoma, arial, &quot;Microsoft YaHei&quot;;"><span style="color: rgb(34, 34, 34); font-family: tahoma, arial, &quot;Microsoft YaHei&quot;;">memory_get_usage()函数返回内存使用量，memory_get_peak_usage()函数返回内存使用峰值，getrusage()返回CUP使用情况。但有一点请注意，在这些函数需要在Linux上运行。</span>', NULL, 'nicd Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae consectetur dolore doloribus id illum unde voluptatibus. Consectetur cupiditate ex hic modi perferendis! Beatae delectus dolores fugit laborum tenetur veniam vitae! sha', '756756765756', b'1', b'0'),
(8, 23, 1, '1111111111', '语法练习语法练习语法练习语法练习语法练习语法练习语法练习语法练习语法练习语法练习语法练习v', NULL, 'There are moments in life when you miss someone so much that you just want to pick them from your dreams and hug them for real! Dream what you want to dream;go where you want to go;be what you want to be,because you have only one life and one chance to do all the things you want to do.\r\n\r\n　　May you have enough happiness to make you sweet,enough trials to make you strong,enough sorrow to keep you human,enough hope to make you happy? Always put yourself in others’shoes.If you feel that it hurts you,it probably hurts the other person, too.', NULL, b'1', b'0');

-- --------------------------------------------------------

--
-- 表的结构 `course_type`
--

CREATE TABLE `course_type` (
  `id` int(11) NOT NULL COMMENT '聚集索引',
  `name` varchar(50) DEFAULT NULL COMMENT '类型名',
  `created_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `course_type`
--

INSERT INTO `course_type` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'Phonics & Pronunciation', 1535417485, 1539923523),
(3, 'Reading & Grammar', 1535417491, 1539923574),
(41, 'Listening Comprehension', 1538790239, 1539923612),
(42, 'i-link Phonics', 1543672700, 1543672700);

-- --------------------------------------------------------

--
-- 表的结构 `instructor`
--

CREATE TABLE `instructor` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `avatar` varchar(256) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `tags` text,
  `abstract` text,
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `instructor`
--

INSERT INTO `instructor` (`id`, `name`, `avatar`, `title`, `tags`, `abstract`, `created_at`, `updated_at`) VALUES
(1, 'Matt Marvuglio', 'http://pdt1od3ni.bkt.clouddn.com/instructor/5bb803178ef3d.jpg', '教授', '英语,口语,吉他,贝斯', '<p><span style="font-family: &quot;Avenir Next Cyr W00 Regular&quot;, Helvetica, Arial, sans-serif; font-size: 15.96px;">Matt Marvuglio（1945-2017）是伯克利学院表演部主任。作为一名精湛的长笛演奏家和作曲家，他走遍了整个美国，欧洲和日本，为他的爵士乐长笛作曲。他为国家长笛协会，美国声学学会和巴西圣保罗的国际长笛大会提供诊所。他的作品“简单的月亮”用于加工长笛，EWI MIDI风控制器以及声学和电子打击乐，可以在Dean Anderson的CD Divinations中听到。Matt的第一张个人专辑“Why Cry？” 有三个他自己的作品和一些旧的最爱的解释。他关于爵士长笛演奏的文章出现在The Instrumentalist中。他是Berklee Practice Method系列的课程编辑和作曲家，当Music Works DVD系列。</span><br></p>', 0, 1538786078),
(2, 'Jim Odgren', 'http://pdt1od3ni.bkt.clouddn.com/instructor/5bb803d767269.jpg', 'Instructor', 'Guitar,Bass', '<span style="font-family: &quot;Avenir Next Cyr W00 Regular&quot;, Helvetica, Arial, sans-serif; font-size: 15.96px;">Jim Odgren is Academic Assistant to the Dean of the Performance Division at Berklee College of Music. Odgren is an alto saxophonist who doubles on tenor and soprano saxophones and flute. Throughout his fifteen-year career at Berklee, he has taught in the Performance Studies and Woodwind Departments. From 1980 to 1983, he toured throughout the world and recorded two LPs (Easy As Pie and Picture This) with the Gary Burton Quartet. Since then, he has recorded and/or played with Kevin Eubanks, John Scofield, Kenwood Denard, Jim Kelly, Victor Mendoza, Oscar Stagnaro, George Garzone, and many others. In 1989, he received the Dean of Faculty Award for his work in improvisation at Berklee. In 2002, Odgren released his own CD, Her Eyes. He is author of the instructional DVD, Accelerate Your Saxophone Playing, and coauthor of two books, Berklee Practice Methods: Getting Your Band Together, with Berklee Woodwind Department Chair, Bill Pierce. Odgren graduated from Berklee College of Music in 1976.</span>', 1535015238, 1538786276);

-- --------------------------------------------------------

--
-- 表的结构 `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1534902237),
('m130524_201442_init', 1534902240),
('m180424_005201_admin', 1534902242),
('m180424_005747_rbac', 1534902244),
('m180424_012504_userinfo', 1534902245);

-- --------------------------------------------------------

--
-- 表的结构 `page`
--

CREATE TABLE `page` (
  `name` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `content` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `page`
--

INSERT INTO `page` (`name`, `title`, `content`) VALUES
('CompanyProfile', '公司介绍', 'dasdasd ');

-- --------------------------------------------------------

--
-- 表的结构 `pronunciation`
--

CREATE TABLE `pronunciation` (
  `id` int(11) NOT NULL,
  `word` varchar(50) NOT NULL,
  `audio` varchar(250) NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `updated_at` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `pronunciation`
--

INSERT INTO `pronunciation` (`id`, `word`, `audio`, `created_at`, `updated_at`) VALUES
(4, 'sha', 'http://pdt1od3ni.bkt.clouddn.com//5bb806ce79df3.wav', 1538787039, 1538787039),
(3, 'nice', 'http://pdt1od3ni.bkt.clouddn.com/pronunciation/5b7d1cac0f18c.mp3', 1534925997, 1534925997);

-- --------------------------------------------------------

--
-- 表的结构 `setting`
--

CREATE TABLE `setting` (
  `key` varchar(128) NOT NULL,
  `value` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `setting`
--

INSERT INTO `setting` (`key`, `value`) VALUES
('test1', 'qwer');

-- --------------------------------------------------------

--
-- 表的结构 `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL COMMENT '作业ID',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '作业类型',
  `course_id` int(11) NOT NULL COMMENT '课程ID',
  `lesson_id` int(11) NOT NULL COMMENT '章节ID',
  `title` varchar(50) NOT NULL COMMENT '作业标题',
  `content` text NOT NULL COMMENT '作业内容',
  `file` varchar(256) DEFAULT NULL COMMENT '作文文件',
  `audio` varchar(256) DEFAULT NULL COMMENT '作业音频',
  `created_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `finish_at` int(11) DEFAULT '0' COMMENT '结束时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `task`
--

INSERT INTO `task` (`id`, `type`, `course_id`, `lesson_id`, `title`, `content`, `file`, `audio`, `created_at`, `finish_at`) VALUES
(1, 0, 2, 6, '3213213213', '2132132131321', NULL, NULL, 0, 1547913600),
(2, 0, 2, 6, '拍一段小视频', '拿起相机，拍一段小视频', NULL, NULL, NULL, NULL),
(3, 0, 2, 6, '作业1', '12321321321', NULL, NULL, 1543887944, 0),
(4, 0, 2, 7, '7567576575', '567657575', NULL, NULL, 1543895029, 1571846400),
(5, 0, 2, 6, 'lalalaa', '<pre style="background-color:#2b2b2b;color:#a9b7c6;font-family:\'Consolas\';font-size:12.0pt;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aliquam amet at consequatur dolorem dolorum ducimus error, harum iste minima molestias obcaecati, officia officiis optio placeat quibusdam rerum temporibus vitae!</pre>', NULL, NULL, 1544237681, 0),
(6, 0, 2, 6, 'FFFFF', '烧死异性恋', NULL, NULL, 1544253551, 1543593600),
(7, 0, 2, 6, 'cxzasdfafasd', 'fqwedasdqweqw', NULL, NULL, 1544254450, 0),
(8, 0, 2, 6, 'sadqwe213213', 'dsadsadsa321321', NULL, NULL, 1544254581, 2476800);

-- --------------------------------------------------------

--
-- 表的结构 `task_submit`
--

CREATE TABLE `task_submit` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `submit_content` text,
  `submit_file` varchar(256) DEFAULT NULL,
  `submit_audio` varchar(256) DEFAULT NULL,
  `reply_content` text,
  `reply_file` varchar(256) DEFAULT NULL,
  `reply_audio` varchar(256) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `submit_at` int(11) DEFAULT '0',
  `reply_at` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `task_submit`
--

INSERT INTO `task_submit` (`id`, `task_id`, `user_id`, `submit_content`, `submit_file`, `submit_audio`, `reply_content`, `reply_file`, `reply_audio`, `status`, `submit_at`, `reply_at`) VALUES
(3, 1, 2, 'asdasdsadsadsa', NULL, NULL, 'dsadsadsadzx78678', NULL, NULL, 2, 1543916626, 1543979295),
(4, 1, 1, 'dasfasgdfsgdfshdfghdgfjdgfjdfghfhfsdf', NULL, NULL, NULL, NULL, NULL, 1, 0, 0),
(5, 1, 1, 'dasfasgdfsgdfshdfghdgfjdgfjdfghfhfsdf', NULL, NULL, NULL, NULL, NULL, 1, 1543981830, 0),
(6, 1, 3, 'sdfvzxcvdzsfdsgdsgdsvxdcv', NULL, NULL, NULL, NULL, NULL, 1, 1543996091, 0),
(7, 2, 1, '<p>sadasda</p>', NULL, NULL, NULL, NULL, NULL, 1, 1544236061, 0),
(8, 3, 1, '<p>dsadas</p>', '[object File]', NULL, NULL, NULL, NULL, 1, 1544237329, 0),
(9, 4, 1, '<p><br></p>', '[object File]', NULL, NULL, NULL, NULL, 1, 1544237395, 0),
(10, 5, 1, '<p>携程支付sad</p>', 'http://192.168.1.12/github/educate/advanced/api/web/v1/upload/get/20181208/5c0b6ff44b51d.png', NULL, NULL, NULL, NULL, 1, 1544253428, 0),
(11, 6, 1, '<p>阿萨德撒发</p>', 'http://192.168.1.12/github/educate/advanced/api/web/v1/upload/get/20181208/5c0b709f504cc.png', NULL, NULL, NULL, NULL, 1, 1544253599, 0),
(12, 7, 1, '<p>dsada</p>', 'http://192.168.1.12/github/educate/advanced/api/web/v1/upload/get/20181208/5c0b74335c85e.png', NULL, NULL, NULL, NULL, 1, 1544254515, 0);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `nickname` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `sex` int(11) DEFAULT '1' COMMENT '性别',
  `avatar` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '头像',
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '电话',
  `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '国家',
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '城市',
  `adderss_1` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '地址1',
  `adderss_2` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '地址2',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `email`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `nickname`, `sex`, `avatar`, `phone`, `country`, `city`, `adderss_1`, `adderss_2`, `created_at`, `updated_at`) VALUES
(1, 'user@yii.com', 'wCWor-N_me6qugwBFkGnW-_9FsPC6NMb', '$2y$13$DAIGH6AXF9mGOHnYa2j7w.FG1VNKtdb7xukhr1U6PtAbDtGh0P1yi', NULL, 1, 'yii123123', 1, 'http://pdt1od3ni.bkt.clouddn.com//5bb851c360398.jpg', '123123', 'sad', 'dsa', '艾欧尼亚', '', 1534902242, 1542980171),
(2, '2321321@11.com', '7q4m4-a6KLnyS9AspO4xFD9CZWoodmL9', '$2y$13$crXXg3GqxeewxVWTlJF7BumWOcvpMDHUhjSTpFRS5Orm.k92xGvfy', NULL, 10, 'qwe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1536043972, 1536043972),
(3, '2321321@112.com', 'AX_dGf3mhaImMC9WmlyfCMXB4V7vgIY3', '$2y$13$9KIrNNOf1GyUmMOWQaVleubDO3DPv5bML8CDiaKoVx/1259.dN8L6', NULL, 10, 'taidi', 0, NULL, '4567568567856', NULL, NULL, NULL, NULL, 1536044027, 1536044497),
(4, 'asd@zxc.com', 'cJVIWeur7ncnz27Rl62dJwDEL6nIs53r', '$2y$13$ZYmH5t0SpgY7kRI0bzXl.efH7Xk1nfEkfsSlikuV3U70Ck.4XzehS', NULL, 10, '卡卡卡卡', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1538808585, 1538808585),
(5, 'sdad@dsa.com', 'RonS8-ZLBFYo9Sv9m37RWMOiFAkENdZw', '$2y$13$K6IsJOKrgz9KG4yUxx8VxOvI637d6nWKK0AipmoPREnBX25c/Irmu', NULL, 10, 'dasdas', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1540823224, 1540823224),
(6, 'sdadaw@ewq.com', 'SX-_XYto9bdLE8iJGbO_DHTHUrs8BsUF', '$2y$13$qDgAnVwhNZv1K4Frfeck7OC01KRcZ79R7W6gRD0M3hZGdeXoBFzIW', NULL, 10, 'adsdsa', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1540824099, 1540824099),
(7, 'aa@qq.com', 'YoIzfpnSvr74DYiTEcy3X7ZKt74f93r3', '$2y$13$vqzEgZCUOUeLZnAF5dSB0.f76VwxTgbHRbRrh9Yjk2Sy0J.5noItu', NULL, 10, 'yamanashi', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1542079447, 1542079447),
(8, 'aaaa@qq.com', 'dg1mz-t3cNVQc0VsGJGhWtR_d8KuT5J-', '$2y$13$of6Vbe2e8axPaD7b0Eb2muCEBwVaMrOg6pzVRTyTf0Am/673Fnql6', NULL, 10, 'yamana', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1542079503, 1542079503),
(9, 'asdasd@sdad.com', 'mS-Lzp7Tv0FcBDwkLyyNbXH3IK1CoQ-F', '$2y$13$vZAkDTXoIaV2sxfvPsicM.oT467snS2Gux8gcla37QXdQWXKfDkIe', NULL, 10, 'asdasd', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1542955799, 1542955799),
(10, '492361988@qq.com', '5yJDAsYha1vvZEnxOUVYmi3L7Zqbll5_', '$2y$13$fWmye/V2xdnCLBhmBQizs.COK04WouUpe0adyVXTjqfBAkBl7Mco2', NULL, 10, 'yamanashi', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1543663356, 1543663356);

-- --------------------------------------------------------

--
-- 表的结构 `user_course`
--

CREATE TABLE `user_course` (
  `user_id` int(11) NOT NULL COMMENT '用户',
  `course_id` int(11) NOT NULL COMMENT '课程',
  `try` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否为试用',
  `tryed_at` int(11) DEFAULT '0' COMMENT '使用结束时间',
  `created_at` int(11) DEFAULT '0' COMMENT '开始时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_course`
--

INSERT INTO `user_course` (`user_id`, `course_id`, `try`, `tryed_at`, `created_at`) VALUES
(1, 2, b'0', 1545362707, 1542770707),
(8, 2, b'0', 0, 1542770847),
(4, 2, b'1', 1545872389, 1543280389),
(4, 3, b'0', 0, 1543280595),
(1, 3, b'0', 0, 1543312924),
(1, 4, b'1', 1545905129, 1543313129),
(10, 2, b'0', 0, 1543663471),
(10, 9, b'0', 0, 1543672458),
(10, 23, b'0', 0, 1543673282);

-- --------------------------------------------------------

--
-- 表的结构 `user_favorite`
--

CREATE TABLE `user_favorite` (
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_favorite`
--

INSERT INTO `user_favorite` (`user_id`, `course_id`, `created_at`) VALUES
(1, 3, 0),
(3, 3, 0),
(4, 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `num` (`num`),
  ADD KEY `FK_course_instructor` (`instructor_id`),
  ADD KEY `FK_course_course_type` (`type_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `course_lesson`
--
ALTER TABLE `course_lesson`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_id_lesson` (`course_id`,`lesson`),
  ADD KEY `num` (`lesson`);

--
-- Indexes for table `course_type`
--
ALTER TABLE `course_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `pronunciation`
--
ALTER TABLE `pronunciation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`word`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_task_course` (`course_id`),
  ADD KEY `FK_task_course_lesson` (`lesson_id`);

--
-- Indexes for table `task_submit`
--
ALTER TABLE `task_submit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_task_submit_task` (`task_id`),
  ADD KEY `FK_task_submit_user` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `user_course`
--
ALTER TABLE `user_course`
  ADD UNIQUE KEY `user_id_course_id` (`user_id`,`course_id`),
  ADD KEY `FK_user_course_course` (`course_id`);

--
-- Indexes for table `user_favorite`
--
ALTER TABLE `user_favorite`
  ADD UNIQUE KEY `user_id_course_id` (`user_id`,`course_id`),
  ADD KEY `FK_user_favorite_course` (`course_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `admin_info`
--
ALTER TABLE `admin_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '聚集索引', AUTO_INCREMENT=24;
--
-- 使用表AUTO_INCREMENT `course_lesson`
--
ALTER TABLE `course_lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '聚集索引', AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `course_type`
--
ALTER TABLE `course_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '聚集索引', AUTO_INCREMENT=43;
--
-- 使用表AUTO_INCREMENT `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `pronunciation`
--
ALTER TABLE `pronunciation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '作业ID', AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `task_submit`
--
ALTER TABLE `task_submit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 限制导出的表
--

--
-- 限制表 `admin_info`
--
ALTER TABLE `admin_info`
  ADD CONSTRAINT `admin_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `FK_course_course_type` FOREIGN KEY (`type_id`) REFERENCES `course_type` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_course_instructor` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`id`) ON DELETE SET NULL;

--
-- 限制表 `course_lesson`
--
ALTER TABLE `course_lesson`
  ADD CONSTRAINT `FK_course_lesson_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_task_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_task_course_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `course_lesson` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `task_submit`
--
ALTER TABLE `task_submit`
  ADD CONSTRAINT `FK_task_submit_task` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_task_submit_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `user_course`
--
ALTER TABLE `user_course`
  ADD CONSTRAINT `FK_user_course_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user_course_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `user_favorite`
--
ALTER TABLE `user_favorite`
  ADD CONSTRAINT `FK_user_favorite_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user_favorite_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
