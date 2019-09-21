-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2019-09-21 09:58:41
-- 服务器版本： 5.7.14-log
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
(1, 1, '管理员', 'http://localhost/test/educate/advanced/backend/web/upload/get/20190619/5d0a0208b4506.jpg', NULL);

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
  `price_dollar` int(11) NOT NULL DEFAULT '0' COMMENT '课程价格(美金)',
  `name` varchar(50) DEFAULT NULL COMMENT '课程名称',
  `name_en` varchar(50) DEFAULT NULL COMMENT '课程名称(英)',
  `image` varchar(256) DEFAULT NULL COMMENT '课程封面',
  `level` int(11) DEFAULT NULL COMMENT '课程难度',
  `period` int(11) NOT NULL DEFAULT '0' COMMENT '课程课时',
  `synopsis` text COMMENT '课程摘要',
  `synopsis_en` text COMMENT '课程摘要(英)',
  `abstract` text COMMENT '课程简介',
  `abstract_en` text COMMENT '课程简介(英)',
  `requirements_prerequisites` text COMMENT '前提',
  `requirements_textbooks` text COMMENT '教科书',
  `requirements_software` text COMMENT '软件要求',
  `requirements_hardware` text COMMENT '硬件要求',
  `requirements_prerequisites_en` text COMMENT '前提(英)',
  `requirements_textbooks_en` text COMMENT '教科书(英)',
  `requirements_software_en` text COMMENT '软件要求(英)',
  `requirements_hardware_en` text COMMENT '硬件要求(英)',
  `try` bit(1) DEFAULT b'0' COMMENT '支持试用',
  `try_day` int(11) DEFAULT '30' COMMENT '试用天数',
  `buy_day` int(11) DEFAULT '180' COMMENT '购买天数',
  `next_term_at` int(11) DEFAULT '0' COMMENT '下学期',
  `created_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`id`, `num`, `type_id`, `instructor_id`, `price`, `price_dollar`, `name`, `name_en`, `image`, `level`, `period`, `synopsis`, `synopsis_en`, `abstract`, `abstract_en`, `requirements_prerequisites`, `requirements_textbooks`, `requirements_software`, `requirements_hardware`, `requirements_prerequisites_en`, `requirements_textbooks_en`, `requirements_software_en`, `requirements_hardware_en`, `try`, `try_day`, `buy_day`, `next_term_at`, `created_at`, `updated_at`) VALUES
(1, 'Num0001', 44, 1, 1, 1, '课程1', 'course1', NULL, 1, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 180, 0, 1566456127, 1566456127),
(2, 'num2', NULL, NULL, 0, 0, '课程2', NULL, NULL, NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0', 30, 180, 0, 1566956801, 1566956801);

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
  `subtitles` json DEFAULT NULL COMMENT '字幕',
  `try` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否试用',
  `free` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否免费'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `course_lesson`
--

INSERT INTO `course_lesson` (`id`, `course_id`, `lesson`, `title`, `abstract`, `video`, `content`, `task`, `subtitles`, `try`, `free`) VALUES
(7, 1, 1, '章节1', '阿闪大大asdasdasdadasdsd', NULL, '<p>asdadsadadsadaddsa</p>', NULL, '[{"time": ["00:00:00", "00:00:10"], "content": "123"}]', b'0', b'0'),
(8, 1, 2, '章节2', NULL, NULL, NULL, NULL, NULL, b'0', b'0'),
(9, 1, 3, '章节3', NULL, NULL, NULL, NULL, NULL, b'0', b'0');

-- --------------------------------------------------------

--
-- 表的结构 `course_type`
--

CREATE TABLE `course_type` (
  `id` int(11) NOT NULL COMMENT '聚集索引',
  `name` varchar(50) DEFAULT NULL COMMENT '类型名',
  `name_en` varchar(50) DEFAULT NULL COMMENT '类型名(英语)',
  `created_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `course_type`
--

INSERT INTO `course_type` (`id`, `name`, `name_en`, `created_at`, `updated_at`) VALUES
(44, '英语拼读', 'English Phonics', 1545293916, 1548405290);

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL COMMENT '客户ID',
  `name` varchar(50) NOT NULL COMMENT '客户名称',
  `quantity` int(11) NOT NULL COMMENT '发放数量',
  `courses` json NOT NULL COMMENT '相关课程(数组)',
  `course_used_at` int(11) NOT NULL COMMENT '课程使用截止日期',
  `expiry_at` int(11) DEFAULT NULL COMMENT '客户兑换码过期日期(预留)',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `customer`
--

INSERT INTO `customer` (`id`, `name`, `quantity`, `courses`, `course_used_at`, `expiry_at`, `created_at`) VALUES
(3, '客户A', 10, '["1", "2"]', 1567180800, 1567180800, 1566956874);

-- --------------------------------------------------------

--
-- 表的结构 `customer_code`
--

CREATE TABLE `customer_code` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `customer_id` int(11) NOT NULL COMMENT '所属客户',
  `code` varchar(50) NOT NULL COMMENT '兑换码',
  `courses` json NOT NULL COMMENT '兑换课程(数组,冗余优化查询)',
  `course_used_at` int(11) NOT NULL COMMENT '课程使用截止时间(冗余优化查询)',
  `state` int(11) DEFAULT '1' COMMENT '兑换券状态',
  `redeem_user_id` int(11) DEFAULT NULL COMMENT '兑换用户ID',
  `expiry_at` int(11) DEFAULT NULL COMMENT '兑换码有效期(预留)',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `customer_code`
--

INSERT INTO `customer_code` (`id`, `customer_id`, `code`, `courses`, `course_used_at`, `state`, `redeem_user_id`, `expiry_at`, `created_at`) VALUES
(14, 3, '5d65dd4ad80e06036', '["1", "2"]', 1567180800, 2, 1, 1567180800, 1566956874),
(15, 3, '5d65dd4ad87405343', '["1", "2"]', 1567180800, 1, NULL, 1567180800, 1566956874),
(16, 3, '5d65dd4ad8d776732', '["1", "2"]', 1567180800, 1, NULL, 1567180800, 1566956874),
(17, 3, '5d65dd4b054db1611', '["1", "2"]', 1567180800, 1, NULL, 1567180800, 1566956875),
(18, 3, '5d65dd4b05b155279', '["1", "2"]', 1567180800, 1, NULL, 1567180800, 1566956875),
(19, 3, '5d65dd4b05fff8897', '["1", "2"]', 1567180800, 1, NULL, 1567180800, 1566956875),
(20, 3, '5d65dd4b0672e9939', '["1", "2"]', 1567180800, 1, NULL, 1567180800, 1566956875),
(21, 3, '5d65dd4b06cc19727', '["1", "2"]', 1567180800, 1, NULL, 1567180800, 1566956875),
(22, 3, '5d65dd4b071cf6192', '["1", "2"]', 1567180800, 1, NULL, 1567180800, 1566956875),
(23, 3, '5d65dd4b0769b5473', '["1", "2"]', 1567180800, 2, 1, 1567180800, 1566956875);

-- --------------------------------------------------------

--
-- 表的结构 `homepage`
--

CREATE TABLE `homepage` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `title_en` varchar(50) DEFAULT NULL,
  `abstract` text,
  `abstract_en` text,
  `image` varchar(256) DEFAULT NULL,
  `content` text,
  `content_en` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `homepage`
--

INSERT INTO `homepage` (`id`, `title`, `title_en`, `abstract`, `abstract_en`, `image`, `content`, `content_en`) VALUES
(1, 'kykyukuyk', '111111', 'uyiyuityityityi', '2222222222', 'http://localhost/github/educate/advanced/backend/web/upload/get/20181224/5c203f0064166.jpg', '<p>yuityuiutyityiytiyitrthutjtyj4564646</p>', '<p>3333333333333<br/></p>');

-- --------------------------------------------------------

--
-- 表的结构 `homepage_items`
--

CREATE TABLE `homepage_items` (
  `id` int(11) NOT NULL,
  `order` int(11) DEFAULT '10',
  `image` varchar(256) DEFAULT NULL,
  `content` text,
  `content_en` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `homepage_items`
--

INSERT INTO `homepage_items` (`id`, `order`, `image`, `content`, `content_en`) VALUES
(1, 30, 'http://localhost/github/educate/advanced/backend/web/upload/get/20181224/5c20721669b46.jpg', '<p>645646546754</p>', '<p>asdfgghdjkljtrerfhte<br/></p>'),
(2, 11, '20181222/5c1e05d9bdb28.jpg', 'asdfasfasfasfasfasfasfasfsa', NULL);

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
-- 表的结构 `order`
--

CREATE TABLE `order` (
  `order_no` varchar(50) NOT NULL,
  `channel` int(11) DEFAULT '1',
  `type` varchar(10) DEFAULT 'H5',
  `openid` varchar(50) NOT NULL,
  `body` varchar(250) NOT NULL,
  `amount_fee` int(11) DEFAULT '1',
  `trade_no` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`order_no`, `channel`, `type`, `openid`, `body`, `amount_fee`, `trade_no`, `user_id`, `course_id`, `datetime`) VALUES
('CN201908221540555d5e47071280c', 2, 'ALIPAY', '2088431887546598', '课程1', 1, '2019082222001466480528533471', 1, 1, '2019-08-22 15:41:24'),
('CN201908221534345d5e458ab5bec', 1, 'NATIVE', 'o8NS51FE28mYUlPZSKRCd0KK-Npw', '课程1', 1, '4200000387201908221021606510', 1, 1, '2019-08-22 15:35:19'),
('CN201908221538475d5e4687dbdbb', 1, 'NATIVE', 'o8NS51FE28mYUlPZSKRCd0KK-Npw', '课程1', 1, '4200000401201908228906688855', 1, 1, '2019-08-22 15:39:28'),
('CN201908221533045d5e4530b6fbf', 1, 'NATIVE', 'o8NS51FE28mYUlPZSKRCd0KK-Npw', '课程1', 1, '4200000382201908226216081572', 1, 1, '2019-08-22 15:33:28'),
('CN201908221531145d5e44c2c55b4', 1, 'NATIVE', 'o8NS51FE28mYUlPZSKRCd0KK-Npw', '课程1', 1, '4200000381201908227478796288', 1, 1, '2019-08-22 15:31:44'),
('CN201908221528445d5e442c00143', 1, 'NATIVE', 'o8NS51FE28mYUlPZSKRCd0KK-Npw', '课程1', 1, '4200000397201908227964839220', 1, 1, '2019-08-22 15:33:18'),
('CN201908221412245d5e3248ba446', 1, 'NATIVE', 'o8NS51FE28mYUlPZSKRCd0KK-Npw', '拼读一', 1, '4200000386201908226206586276', 1, 26, '2019-08-22 15:47:02'),
('CN201908221413385d5e32924a232', 1, 'NATIVE', 'o8NS51FE28mYUlPZSKRCd0KK-Npw', '拼读一', 1, '4200000398201908227876146581', 1, 26, '2019-08-22 15:49:00'),
('CN201908221659135d5e5961bf2bf', 2, 'ALIPAY', '2088431887546598', '课程1', 1, '2019082222001466480533602222', 1, 1, '2019-08-22 16:59:50'),
('CN201908230840415d5f360970eb1', 2, 'ALIPAY', '2088431887546598', '课程1', 1, '2019082322001466480535642549', 1, 1, '2019-08-23 08:41:06'),
('CN201908230915345d5f3e363c555', 1, 'NATIVE', 'o8NS51FE28mYUlPZSKRCd0KK-Npw', '课程1', 1, '4200000393201908232161129747', 1, 1, '2019-08-23 09:16:02'),
('CN201909061542505d720dfa23681', 1, 'NATIVE', 'o8NS51FE28mYUlPZSKRCd0KK-Npw', '课程1', 1, '4200000383201909064268821733', 1, 1, '2019-09-06 15:43:20'),
('CN201909061544005d720e404d662', 1, 'NATIVE', 'o8NS51FE28mYUlPZSKRCd0KK-Npw', '课程1', 1, '4200000389201909066462947469', 2, 1, '2019-09-06 15:44:18');

-- --------------------------------------------------------

--
-- 表的结构 `page`
--

CREATE TABLE `page` (
  `name` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `content` longtext,
  `content_en` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `page`
--

INSERT INTO `page` (`name`, `title`, `content`, `content_en`) VALUES
('Methods', '学习模式', '<p>asfdgfdfhgfhjgjvghjghjhgjhg</p>', '<p>gdfhfjghfjghfjhgfjgfhgfhfghhgfhdf<br/></p>'),
('CompanyProfile', '公司介绍', 'dasdasd ', NULL),
('TermsOfUse', '使用条款', '', NULL),
('CopyrightPolicy', '版权政策', '电饭锅和豆腐干和', NULL);

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
(4, 'sha', 'http://localhost/github/educate/advanced/backend/web/upload/get/20181224/5c2071a69f1bd.wav', 1538787039, 1545630124),
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
('point_percent_complete', '10'),
('point_percent_buy', '5'),
('point_percent_invitee_buy', '20'),
('point_fix_register', '20');

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
(1, 0, 1, 7, '作业1', '<p>作业内容1</p>', NULL, NULL, 1566868857, 0),
(2, 0, 1, 8, '作业2', '<p>作业内容2</p>', NULL, NULL, 1566868881, 0);

-- --------------------------------------------------------

--
-- 表的结构 `task_submit`
--

CREATE TABLE `task_submit` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `task_id` int(11) NOT NULL COMMENT '作业ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `course_id` int(11) DEFAULT NULL COMMENT '课程ID(添加，冗余字段用于查询统计)',
  `submit_content` text COMMENT '作业提交内容',
  `submit_file` varchar(256) DEFAULT NULL COMMENT '作业提交文件',
  `submit_audio` varchar(256) DEFAULT NULL COMMENT '作业提交音频',
  `reply_content` text COMMENT '导师回复内容',
  `reply_file` varchar(256) DEFAULT NULL COMMENT '导师回复文件',
  `reply_audio` varchar(256) DEFAULT NULL COMMENT '导师回复音频',
  `status` int(11) DEFAULT '1' COMMENT '作业状态',
  `submit_at` int(11) DEFAULT '0' COMMENT '提交时间',
  `reply_at` int(11) DEFAULT '0' COMMENT '回复时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `task_submit`
--

INSERT INTO `task_submit` (`id`, `task_id`, `user_id`, `course_id`, `submit_content`, `submit_file`, `submit_audio`, `reply_content`, `reply_file`, `reply_audio`, `status`, `submit_at`, `reply_at`) VALUES
(33, 1, 1, 1, '提交内容', '', '', '回复内容', NULL, NULL, 2, 1567754608, 1567754664),
(34, 2, 1, 1, '提交内容', '', '', '回复内容2', NULL, NULL, 2, 1567754619, 1567754972);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `login_token` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '登录状态TOKEN',
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
  `customer` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '所属大客户(名称)',
  `invite_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '邀请码',
  `inviter_id` int(11) DEFAULT NULL COMMENT '邀请人ID(用户ID)',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `email`, `auth_key`, `login_token`, `password_hash`, `password_reset_token`, `status`, `nickname`, `sex`, `avatar`, `phone`, `country`, `city`, `adderss_1`, `adderss_2`, `customer`, `invite_code`, `inviter_id`, `created_at`, `updated_at`) VALUES
(1, 'evon1991@163.com', 'sjg9bpjNknx2GX3sIEmob3ApTLODHChV', '5d70c0e2b0921', '$2y$13$5NX02jW8Ith0QfY9hcRf9uA5wnwMMAwJX4sAs5.7EXLsDIpY3.mPC', NULL, 10, 'Evon', 1, 'http://pdt1od3ni.bkt.clouddn.com//5bb851c360398.jpg', '159********', '艾欧尼亚', '皮尔沃夫', '艾欧尼亚', '皮尔沃夫', '客户A', '5d7203bfc0626', NULL, 1565863209, 1567671580),
(2, 'user@yii.com', 'BspboFrSbq3JY_1Yyu4RcXkHuFypIlRu', NULL, '$2y$13$NDG6M3FCKmO8I/0ay2ehnenx6Ir1FYdqVqOjNCti7XvF.rGOYxWZS', NULL, 10, 'yii123123', 1, 'http://pdt1od3ni.bkt.clouddn.com//5bb851c360398.jpg', '123123', 'sad', 'dsa', '艾欧尼亚', '', NULL, '5d720433cb222', 1, 1567753267, 1567753267);

-- --------------------------------------------------------

--
-- 表的结构 `user_course`
--

CREATE TABLE `user_course` (
  `user_id` int(11) NOT NULL COMMENT '用户',
  `course_id` int(11) NOT NULL COMMENT '课程',
  `try` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否为试用',
  `tryed_at` int(11) DEFAULT '0' COMMENT '试用结束时间',
  `used_at` int(11) DEFAULT '0' COMMENT '使用结束时间',
  `created_at` int(11) DEFAULT '0' COMMENT '开始时间',
  `progress_total` int(11) DEFAULT '0' COMMENT '进度-总进度',
  `progress_submit` int(11) DEFAULT '0' COMMENT '进度-已提交',
  `progress_completed` int(11) DEFAULT '0' COMMENT '进度-已完成',
  `is_completed` bit(1) DEFAULT b'0' COMMENT '是否已经完成课程'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_course`
--

INSERT INTO `user_course` (`user_id`, `course_id`, `try`, `tryed_at`, `used_at`, `created_at`, `progress_total`, `progress_submit`, `progress_completed`, `is_completed`) VALUES
(1, 1, b'0', 1570346443, 1601450443, 1567754443, 2, 0, 2, b'1'),
(2, 1, b'0', 0, 1585899858, 1567755858, 2, 0, 0, b'0');

-- --------------------------------------------------------

--
-- 表的结构 `user_favorite`
--

CREATE TABLE `user_favorite` (
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_point`
--

CREATE TABLE `user_point` (
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `total` int(11) NOT NULL DEFAULT '0' COMMENT '用户总积分'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_point`
--

INSERT INTO `user_point` (`user_id`, `total`) VALUES
(1, 1524),
(2, 5);

-- --------------------------------------------------------

--
-- 表的结构 `user_point_history`
--

CREATE TABLE `user_point_history` (
  `id` bigint(20) NOT NULL COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `increment` int(11) NOT NULL COMMENT '积分变动',
  `remark` varchar(128) NOT NULL COMMENT '积分变动内容',
  `time` datetime NOT NULL COMMENT '积分变动时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_point_history`
--

INSERT INTO `user_point_history` (`id`, `user_id`, `increment`, `remark`, `time`) VALUES
(24, 1, 0, '邀请注册奖励', '2019-09-06 15:01:07'),
(25, 1, 500, '完成课程奖励', '2019-09-06 15:25:19'),
(26, 1, 1000, '完成课程奖励', '2019-09-06 15:29:34'),
(27, 1, 5, '购买课程奖励', '2019-09-06 15:43:21'),
(28, 2, 5, '购买课程奖励', '2019-09-06 15:44:20'),
(29, 1, 20, '受邀人购买课程奖励', '2019-09-06 15:44:20'),
(30, 1, -1, '积分兑换课程', '2019-09-06 16:18:38');

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
  ADD KEY `name` (`name`),
  ADD KEY `name_en` (`name_en`);

--
-- Indexes for table `course_lesson`
--
ALTER TABLE `course_lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `num` (`lesson`),
  ADD KEY `FK_course_lesson_course` (`course_id`);

--
-- Indexes for table `course_type`
--
ALTER TABLE `course_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_code`
--
ALTER TABLE `customer_code`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `homepage`
--
ALTER TABLE `homepage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepage_items`
--
ALTER TABLE `homepage_items`
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
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_no`);

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
  ADD UNIQUE KEY `task_id_user_id` (`task_id`,`user_id`),
  ADD KEY `FK_task_submit_user` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `course_id` (`course_id`);

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
-- Indexes for table `user_point`
--
ALTER TABLE `user_point`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_point_history`
--
ALTER TABLE `user_point_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '聚集索引', AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `course_lesson`
--
ALTER TABLE `course_lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '聚集索引', AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `course_type`
--
ALTER TABLE `course_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '聚集索引', AUTO_INCREMENT=45;
--
-- 使用表AUTO_INCREMENT `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客户ID', AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `customer_code`
--
ALTER TABLE `customer_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=24;
--
-- 使用表AUTO_INCREMENT `homepage`
--
ALTER TABLE `homepage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `homepage_items`
--
ALTER TABLE `homepage_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '作业ID', AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `task_submit`
--
ALTER TABLE `task_submit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=35;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `user_point_history`
--
ALTER TABLE `user_point_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=31;
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
-- 限制表 `customer_code`
--
ALTER TABLE `customer_code`
  ADD CONSTRAINT `FK_customer_code_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- 限制表 `user_point`
--
ALTER TABLE `user_point`
  ADD CONSTRAINT `FK_user_point_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `user_point_history`
--
ALTER TABLE `user_point_history`
  ADD CONSTRAINT `FK_user_point_history_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
