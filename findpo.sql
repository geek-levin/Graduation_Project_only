-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 06 月 10 日 04:33
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `findpo`
--

-- --------------------------------------------------------

--
-- 表的结构 `po_account`
--

CREATE TABLE IF NOT EXISTS `po_account` (
  `uid` int(11) NOT NULL COMMENT '用户id',
  `paypassword` varchar(16) DEFAULT NULL COMMENT '密码',
  `balance` float NOT NULL DEFAULT '0' COMMENT '账户余额',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户账户表';

--
-- 转存表中的数据 `po_account`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_address`
--

CREATE TABLE IF NOT EXISTS `po_address` (
  `uid` int(11) NOT NULL COMMENT '用户id',
  `consignee_one` varchar(50) DEFAULT NULL COMMENT '收货人1',
  `college_one` varchar(50) DEFAULT NULL COMMENT '学校1',
  `address_one` varchar(255) DEFAULT NULL COMMENT '收货地址1',
  `zipcode_one` int(6) DEFAULT NULL COMMENT '邮编1',
  `phone_one` varchar(50) DEFAULT NULL COMMENT '联系电话1',
  `consignee_two` varchar(50) DEFAULT NULL COMMENT '收货人2',
  `college_two` varchar(50) DEFAULT NULL COMMENT '学校2',
  `address_two` varchar(255) DEFAULT NULL COMMENT '收货地址2',
  `zipcode_two` int(6) DEFAULT NULL COMMENT '邮编2',
  `phone_two` varchar(50) DEFAULT NULL COMMENT '联系电话2',
  `consignee_three` varchar(50) DEFAULT NULL COMMENT '收货人3',
  `college_three` varchar(50) DEFAULT NULL COMMENT '学校3',
  `address_three` varchar(255) DEFAULT NULL COMMENT '收货地址3',
  `zipcode_three` int(6) DEFAULT NULL COMMENT '邮编3',
  `phone_three` varchar(50) DEFAULT NULL COMMENT '联系电话3',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户收货地址表';

--
-- 转存表中的数据 `po_address`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_admin`
--

CREATE TABLE IF NOT EXISTS `po_admin` (
  `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `name` varchar(16) NOT NULL COMMENT '帐号名',
  `realname` varchar(30) NOT NULL COMMENT '真实姓名',
  `password` varchar(16) NOT NULL COMMENT '密码',
  `permission` tinyint(1) NOT NULL DEFAULT '0' COMMENT '权限',
  `lastlogin` datetime DEFAULT NULL COMMENT '最后登陆时间',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `po_admin`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_cart`
--

CREATE TABLE IF NOT EXISTS `po_cart` (
  `uid` int(11) NOT NULL COMMENT '用户id',
  `item_a` varchar(100) DEFAULT NULL COMMENT '商品1',
  `item_b` varchar(100) DEFAULT NULL COMMENT '商品2',
  `item_c` varchar(100) DEFAULT NULL COMMENT '商品3',
  `item_d` varchar(100) DEFAULT NULL COMMENT '商品4',
  `item_e` varchar(100) DEFAULT NULL COMMENT '商品5',
  `item_f` varchar(100) DEFAULT NULL COMMENT '商品6',
  `item_g` varchar(100) DEFAULT NULL COMMENT '商品7',
  `item_h` varchar(100) DEFAULT NULL COMMENT '商品8',
  `item_i` varchar(100) DEFAULT NULL COMMENT '商品9',
  `item_j` varchar(100) DEFAULT NULL COMMENT '商品10',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='购物车表';

--
-- 转存表中的数据 `po_cart`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_category`
--

CREATE TABLE IF NOT EXISTS `po_category` (
  `catid` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品分类id',
  `parentid` int(11) DEFAULT NULL COMMENT '父id',
  `classname` varchar(50) NOT NULL COMMENT '分类名称',
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品分类表' AUTO_INCREMENT=130 ;

--
-- 转存表中的数据 `po_category`
--

INSERT INTO `po_category` (`catid`, `parentid`, `classname`) VALUES
(1, NULL, '票务卡类'),
(2, 1, '移动'),
(3, 1, '联通'),
(4, 1, '电信'),
(5, 1, '汽车票'),
(6, 1, '火车票'),
(7, 1, 'qq卡'),
(8, 1, '游戏点卡'),
(9, 1, '景区门票'),
(10, 1, '演唱会门票'),
(11, NULL, '数码'),
(12, 11, '手机'),
(13, 11, '数码相机'),
(14, 11, '单反'),
(15, 11, '胶卷相机'),
(16, 11, '摄像机'),
(17, 11, '相机配件'),
(18, 11, 'mp3'),
(19, 11, 'mp4'),
(20, 11, 'mp5'),
(21, 11, 'u盘'),
(22, 11, 'SD卡'),
(23, 11, '移动硬盘'),
(24, 11, '音箱'),
(25, 11, '组装机'),
(26, 11, '笔记本'),
(27, 11, '平板'),
(28, 11, '刻录盘'),
(29, 11, 'PSP'),
(30, 11, '游戏手柄'),
(31, 11, '掌上游戏机'),
(32, 11, '电脑硬件'),
(33, 32, '键盘'),
(34, 32, '鼠标'),
(35, 32, '摄像头'),
(36, 32, '音响'),
(37, 32, '显示器'),
(38, 32, '内存'),
(39, 32, '主板'),
(40, 32, '硬盘'),
(41, 32, '显卡'),
(42, 32, '声卡'),
(43, 32, '机箱'),
(44, 32, '电源'),
(45, 32, '散热器'),
(46, 32, '光驱'),
(47, 32, '其他硬件'),
(48, 11, '数码配件'),
(49, 48, '手机保护壳'),
(50, 48, '贴膜'),
(51, 48, '电池'),
(52, 48, '充电器'),
(53, 48, '耳机'),
(54, 48, '数据线'),
(55, 48, '笔记本包'),
(56, 48, '电源'),
(57, 48, '路由器'),
(58, NULL, '电器/家居'),
(59, 58, '电风扇'),
(60, 58, '台灯'),
(61, 58, '复读机'),
(62, 58, '收音机'),
(63, 58, '床上书桌'),
(64, 58, '摆件'),
(65, 58, '其它'),
(66, NULL, '箱包'),
(67, 66, '单肩包'),
(68, 66, '双肩包'),
(69, 66, '手提包'),
(70, 66, '斜挎包'),
(71, 66, '钱包'),
(72, 66, '腰包'),
(73, 66, '卡包'),
(74, 66, '公文包'),
(75, 66, '拉杆箱'),
(76, 66, '旅行箱'),
(77, NULL, '衣物/饰品'),
(78, NULL, '美容/化妆'),
(79, NULL, '日用品'),
(80, 79, '雨伞'),
(81, 79, '相册'),
(82, 79, '烟灰缸'),
(83, 79, '钥匙扣'),
(84, 79, '储蓄罐'),
(85, 79, '闹钟'),
(86, 79, '杯具'),
(87, 79, '收纳盒'),
(88, 79, '毛球修剪器'),
(89, 79, '衣物除尘滚'),
(90, NULL, '运动户外'),
(91, 90, '旱冰鞋'),
(92, 90, '溜冰鞋'),
(93, 90, '羽球拍'),
(94, 90, '乒乓拍'),
(95, 90, '网球拍'),
(96, 90, '网球'),
(97, 90, '足球'),
(98, 90, '篮球'),
(99, 90, '高尔夫球杆'),
(100, 90, '自行车'),
(101, 90, '山地车'),
(102, 90, '折叠车'),
(103, 90, '单车配件'),
(104, 90, '滑板'),
(105, 90, '望远镜'),
(106, 90, '呼啦圈'),
(107, NULL, '玩具/动漫'),
(108, 107, '毛绒玩具'),
(109, 107, '遥控动力'),
(110, 107, '动漫周边'),
(111, 107, '创意玩具'),
(112, 107, '桌游'),
(113, 107, '模型'),
(114, NULL, '书籍/文化用品'),
(115, 114, '电子文具'),
(116, 114, '文化用品'),
(117, 114, '纸薄/本册'),
(118, 114, '乐器'),
(119, 114, '书报杂志'),
(120, 119, '课本'),
(121, 119, '课外读物'),
(122, NULL, '个性定制'),
(123, 122, '杯子'),
(124, 122, '相册'),
(125, 122, '制服'),
(126, 122, '钱包'),
(127, 122, '趣味证书'),
(128, 122, '其它'),
(129, NULL, '其它');

-- --------------------------------------------------------

--
-- 表的结构 `po_comment`
--

CREATE TABLE IF NOT EXISTS `po_comment` (
  `cid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评价id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `username` varchar(16) NOT NULL COMMENT '用户名',
  `nickname` varchar(16) DEFAULT NULL COMMENT '用户昵称',
  `pid` int(11) NOT NULL COMMENT '商品id',
  `comment` varchar(500) NOT NULL COMMENT '评论',
  `time` datetime DEFAULT NULL COMMENT '发表时间',
  `read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否非法',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品评价表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `po_comment`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_favorite`
--

CREATE TABLE IF NOT EXISTS `po_favorite` (
  `fid` int(11) NOT NULL AUTO_INCREMENT COMMENT '收藏id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `pid` int(11) DEFAULT NULL COMMENT '商品id',
  `sid` int(11) DEFAULT NULL COMMENT '商店id',
  `time` datetime DEFAULT NULL COMMENT '收藏日期',
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品收藏表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `po_favorite`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_order`
--

CREATE TABLE IF NOT EXISTS `po_order` (
  `oid` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `pid` int(11) NOT NULL COMMENT '商品id',
  `saleuid` int(11) NOT NULL COMMENT '卖家uid',
  `buyuid` int(11) NOT NULL COMMENT '买家uid',
  `username` varchar(16) DEFAULT NULL COMMENT '用户名',
  `nickname` varchar(16) DEFAULT NULL COMMENT '用户昵称',
  `price` float NOT NULL COMMENT '商品单价',
  `amount` int(11) NOT NULL COMMENT '商品数量',
  `total` float NOT NULL COMMENT '交易总额',
  `note` varchar(100) DEFAULT NULL COMMENT '备注',
  `address` varchar(255) DEFAULT NULL COMMENT '收货地址',
  `time` datetime DEFAULT NULL COMMENT '订单产生时间',
  `time_pay` datetime DEFAULT NULL COMMENT '买家支付时间',
  `time_ship` datetime DEFAULT NULL COMMENT '卖家发货时间',
  `time_return` datetime DEFAULT NULL COMMENT '买家退货时间',
  `time_refund` datetime DEFAULT NULL COMMENT '卖家退款时间',
  `time_over` datetime DEFAULT NULL COMMENT '交易结束时间',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态',
  `feel` tinyint(1) DEFAULT NULL COMMENT '商品评价',
  `mark` tinyint(1) DEFAULT NULL COMMENT '标记卖家评价',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `po_order`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_product`
--

CREATE TABLE IF NOT EXISTS `po_product` (
  `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `uid` int(11) NOT NULL COMMENT '发布人id',
  `sid` int(11) NOT NULL COMMENT '商店id',
  `catid` int(11) NOT NULL COMMENT '商品分类id',
  `title` varchar(50) NOT NULL COMMENT '商品标题',
  `mprice` float DEFAULT NULL COMMENT '市场价',
  `price` float NOT NULL COMMENT '单价',
  `new_old` int(2) DEFAULT NULL COMMENT '几成新',
  `detail` varchar(10000) DEFAULT NULL COMMENT '商品描述',
  `amount` int(11) NOT NULL COMMENT '商品数量',
  `visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可见',
  `cost` float NOT NULL DEFAULT '0' COMMENT '运费',
  `ex_range` varchar(50) DEFAULT NULL COMMENT '交易范围',
  `wot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '交易方式',
  `release` datetime DEFAULT NULL COMMENT '发布日期',
  `image_one` varchar(50) DEFAULT NULL COMMENT '商品图片1',
  `image_two` varchar(50) DEFAULT NULL COMMENT '商品图片2',
  `image_three` varchar(50) DEFAULT NULL COMMENT '商品图片3',
  `image_four` varchar(50) DEFAULT NULL COMMENT '商品图片4',
  `image_five` varchar(50) DEFAULT NULL COMMENT '商品图片5',
  `end` datetime DEFAULT NULL COMMENT '下架时间',
  `views` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `update` datetime DEFAULT NULL COMMENT '最后修改',
  `read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否非法',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品信息表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `po_product`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_real`
--

CREATE TABLE IF NOT EXISTS `po_real` (
  `uid` int(11) NOT NULL COMMENT '用户id',
  `name` varchar(30) DEFAULT NULL COMMENT '真实名字',
  `college` varchar(50) DEFAULT NULL COMMENT '所在学校',
  `idnumber` varchar(18) DEFAULT NULL COMMENT '身份证号',
  `idimage` varchar(50) DEFAULT NULL COMMENT '认证图片',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户真实信息表';

--
-- 转存表中的数据 `po_real`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_setting`
--

CREATE TABLE IF NOT EXISTS `po_setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '配置id',
  `city` varchar(50) NOT NULL COMMENT '城市',
  `college` varchar(500) NOT NULL COMMENT '大学，以*分隔',
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='网站基础数据设置表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `po_setting`
--

INSERT INTO `po_setting` (`setting_id`, `city`, `college`) VALUES
(1, '江苏科技大学', '东校区*西校区*南徐校区');

-- --------------------------------------------------------

--
-- 表的结构 `po_shop`
--

CREATE TABLE IF NOT EXISTS `po_shop` (
  `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT '商店id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `shop` varchar(50) DEFAULT NULL COMMENT '商店名称',
  `introduce` varchar(600) DEFAULT NULL COMMENT '商店介绍',
  `reg_date` datetime DEFAULT NULL COMMENT '开店日期',
  `notice` varchar(200) DEFAULT NULL COMMENT '商店公告',
  `sale_count` int(11) NOT NULL DEFAULT '0' COMMENT '销售件数',
  `read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否非法',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商店表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `po_shop`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_trade`
--

CREATE TABLE IF NOT EXISTS `po_trade` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT '明细id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `oid` int(11) DEFAULT NULL COMMENT '订单id',
  `amount` float NOT NULL COMMENT '数额',
  `type` tinyint(1) NOT NULL COMMENT '交易类型',
  `time` datetime NOT NULL COMMENT '发生时间',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户账户明细表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `po_trade`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_user`
--

CREATE TABLE IF NOT EXISTS `po_user` (
  `uid` int(11) NOT NULL COMMENT '用户id',
  `username` varchar(16) NOT NULL COMMENT '用户名',
  `nickname` varchar(16) DEFAULT NULL COMMENT '用户昵称',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别，默认为0',
  `intro` varchar(400) DEFAULT NULL COMMENT '自我介绍',
  `usertype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户类型',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `validated` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email验证状态',
  `photo` varchar(255) DEFAULT NULL COMMENT '照片或形象',
  `college` tinyint(2) DEFAULT NULL COMMENT '学校',
  `academy` varchar(255) DEFAULT NULL COMMENT '学院',
  `address` varchar(255) DEFAULT NULL COMMENT '具体地址',
  `phone` varchar(25) DEFAULT NULL COMMENT '联系电话',
  `qq` varchar(50) DEFAULT NULL COMMENT 'QQ号码',
  `qq_wp` varchar(300) DEFAULT NULL COMMENT '卖家QQ在线状态代码',
  `exchange` int(11) NOT NULL DEFAULT '0' COMMENT '交易次数',
  `exchange_seller` int(11) NOT NULL DEFAULT '0' COMMENT '卖家交易次数',
  `sale_good` int(11) NOT NULL DEFAULT '0' COMMENT '卖家好评',
  `sale_neutral` int(11) NOT NULL DEFAULT '0' COMMENT '卖家中评',
  `sale_bad` int(11) NOT NULL DEFAULT '0' COMMENT '卖家差评',
  `buy_good` int(11) NOT NULL DEFAULT '0' COMMENT '买家好评',
  `buy_neutral` int(11) NOT NULL DEFAULT '0' COMMENT '买家中评',
  `buy_bad` int(11) NOT NULL DEFAULT '0' COMMENT '买家差评',
  `reg_date` datetime DEFAULT NULL COMMENT '注册时间',
  `lastlogin` datetime DEFAULT NULL COMMENT '最后登陆',
  `login_count` int(11) NOT NULL DEFAULT '1' COMMENT '登陆次数',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户信息表';

--
-- 转存表中的数据 `po_user`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_user_pass`
--

CREATE TABLE IF NOT EXISTS `po_user_pass` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(16) NOT NULL COMMENT '用户名',
  `password` varchar(16) NOT NULL COMMENT '密码',
  `read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1禁止登陆，默认为0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户密码表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `po_user_pass`
--


-- --------------------------------------------------------

--
-- 表的结构 `po_wanted`
--

CREATE TABLE IF NOT EXISTS `po_wanted` (
  `wid` int(11) NOT NULL AUTO_INCREMENT COMMENT '求购id',
  `uid` int(11) NOT NULL COMMENT '发布者id',
  `type` tinyint(1) DEFAULT NULL COMMENT '信息种类',
  `name` varchar(50) NOT NULL COMMENT '商品名称',
  `detail` varchar(500) DEFAULT NULL COMMENT '商品描述',
  `price` float DEFAULT NULL COMMENT '商品价格',
  `amount` int(11) DEFAULT NULL COMMENT '商品数量',
  `deadline` datetime DEFAULT NULL COMMENT '截至日期',
  `time` datetime DEFAULT NULL COMMENT '发布日期',
  `read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否非法',
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='二手交易信息表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `po_wanted`
--

