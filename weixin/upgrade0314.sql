CREATE TABLE IF NOT EXISTS `weixin_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createtime` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `value` (`value`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='扫描登陆表' AUTO_INCREMENT=1 ;