<?php
define ( 'IN_ECS', true );
require (dirname ( __FILE__ ) . '/includes/init.php');
$act = trim ( $_REQUEST ['act'] );
switch ($act){
	case "config":
		if($_POST){
			$token = getstr($_POST ['token']);
			$appid = getstr($_POST ['appid']);
			$appsecret = getstr($_POST ['appsecret']);
			$followmsg = getstr($_POST ['followmsg']);
			$helpmsg = getstr($_POST ['helpmsg']);
			$bindmsg = getstr($_POST ['bindmsg']);
			$bonustype = intval($_POST ['bonustype']);
			$bonustype2 = intval($_POST ['bonustype2']);
			$wap_url = getstr($_POST ['wap_url']);
			$ret = $db->query ( 
					"UPDATE `weixin_config` SET 
					`token`='$token',
					`appid`='$appid',
					`appsecret`='$appsecret',
					`followmsg`='$followmsg',
					`bindmsg`='$bindmsg',
					`bonustype`='$bonustype',
					`bonustype2`='$bonustype2',
					`wap_url`='$wap_url',
					`helpmsg`='$helpmsg'
					 WHERE `id`=1;" );
			$link [] = array ('href' => 'weixin.php?act=config','text' => '微信设置');
			if ($ret) {
				sys_msg ( '设置成功', 0, $link );
			} else {
				sys_msg ( '设置失败，请重试', 0, $link );
			}
		}else{
			$ymd = date('Y-m-d');
			$bonus = $GLOBALS['db']->getAll('SELECT * FROM '.$ecs->table('bonus_type').
					" where send_end_date>='{$ymd}' and send_type=0");
			$bonus2 = $GLOBALS['db']->getAll('SELECT * FROM '.$ecs->table('bonus_type').
					" where send_end_date>='{$ymd}' and send_type=3");
			$ret = $db->getRow ( "SELECT * FROM `weixin_config` WHERE `id` = 1" );
			$smarty->assign ( 'token', $ret ['token'] );
			$smarty->assign ( 'appid', $ret ['appid'] );
			$smarty->assign ( 'appsecret', $ret ['appsecret'] );
			$smarty->assign ( 'followmsg', $ret ['followmsg'] );
			$smarty->assign ( 'helpmsg', $ret ['helpmsg'] );
			$smarty->assign ( 'bonustype', $ret ['bonustype'] );
			$smarty->assign ( 'bindmsg', $ret ['bindmsg'] );
			$smarty->assign ( 'bonustype2', $ret ['bonustype2'] );
			$smarty->assign ( 'buynotice', $ret ['buynotice'] );
			$smarty->assign ( 'sendnotice', $ret ['sendnotice'] );
			$smarty->assign ( 'bonus', $bonus );
			$smarty->assign ( 'bonus2', $bonus2 );
			$smarty->assign ( 'wap_url', $ret['wap_url'] );
			$smarty->display ( 'weixin/wx_config.html' );
		}
	break;
	case "menu"://菜单页面
		if($_POST){
			
		}else{
			$ret = $db->getAll ( "SELECT * FROM `weixin_menu` order by `order` desc" );
			$menu = $pmenu = array();
			if($ret){
				foreach ($ret as $v){
					if($v['pid'] == 0){
						$pmenu[] = $v;
					}else{
						$menu[$v['pid']][] = $v;
					}
				}
			}
			$smarty->assign ( 'menu', $menu );
			$smarty->assign ( 'pmenu', $pmenu );
			$smarty->display ( 'weixin/wx_menu.html' );
		}
	break;
	case "delmenu":
		$id = intval($_GET['id']);
		$ret = $db->getRow ( "SELECT pid FROM `weixin_menu` WHERE `id` = $id" );
		if($ret['pid'] == 0){
			$db->query("DELETE FROM `weixin_menu` WHERE `pid` = {$id};");
		}
		$db->query("DELETE FROM `weixin_menu` WHERE `id` = $id;");
		$link [] = array ('href' => 'weixin.php?act=menu','text' => '自定义菜单');
		update_menu();
		sys_msg ( '删除成功', 0, $link );
		break;
	case "addmenu"://添加菜单
		$id = intval($_REQUEST['id']);
		if($_POST){
			require_once(ROOT_PATH . 'includes/cls_image.php');
			$helpmsg = getstr($_POST ['helpmsg']);
			$pid = intval($_POST['pid']);
			$name = getstr($_POST['name']);
			$value = getstr($_POST['value']);
			$type = intval($_POST['type']);
			$order = intval($_POST['order']);
			if($type == 3){
				$value = "article_".addNews();
			}
			if($id){
				$ret = $db->query (
					"UPDATE `weixin_menu` SET
					`pid`='$pid',
					`name`='$name',
					`type`='$type',
					`order`='$order',
					`value`='$value'
					WHERE `id`=$id;" );
				$link [] = array ('href' => 'weixin.php?act=menu','text' => '自定义菜单');
			}else{
				$link [] = array ('href' => 'weixin.php?act=addmenu','text' => '添加自定义菜单');
				$ret = $db->query ( "INSERT INTO `weixin_menu` (`pid`, `name`, `type`, `value`,`order`)
					VALUES('$pid', '$name', $type, '$value','$order');" );
			}
			update_menu();
			if ($ret) {
				sys_msg ( '添加成功', 0, $link );
			} else {
				sys_msg ( '添加失败，请重试', 0, $link );
			}
		}else{
			$ret = $db->getAll ( "SELECT * FROM `weixin_menu` WHERE `pid` = 0" );
			if($id > 0) $menu = $db->getRow ( "SELECT * FROM `weixin_menu` WHERE `id` = $id" );
			if($menu['type'] == 3){
				$articleId = str_replace('article_','',$menu['value']);
				$artInfo = $db->getRow("select * from ".$ecs->table('article')." where article_id='{$articleId}'");
				$smarty->assign ( 'article', $artInfo );
			}
			$smarty->assign ( 'menu', $menu );
			$smarty->assign ( 'pmenu', $ret );
			$smarty->display ( 'weixin/wx_addmenu.html' );
		}
		break;
	case "keywords":
		$id = intval($_GET['id']);
		if($id){
			if($_POST){
				$keys = getstr($_POST['keys']);
				$keyname = getstr($_POST['keyname']);
				$jf_type = intval($_POST['jf_type']);
				$jf_num = intval($_POST['jf_num']) > 0 ? intval($_POST['jf_num']) : 0;
				$jf_maxnum = intval($_POST['jf_maxnum']) > 0 ? intval($_POST['jf_maxnum']) : 0;
				$ret = $GLOBALS['db']->query("
					UPDATE `weixin_keywords` SET 
					`keys`='$keys',
					`keyname`='$keyname',
					`jf_type`='$jf_type',
					`jf_num`='$jf_num',
					`jf_maxnum`='$jf_maxnum'
					 WHERE `id`=$id;
				");
				$link [] = array ('href' => 'weixin.php?act=keywords','text' => '功能变量');
				if ($ret) {
					sys_msg ( '编辑成功', 0, $link );
				} else {
					sys_msg ( '编辑失败，请重试', 0, $link );
				}
			}
			$keywords = $GLOBALS['db']->getRow("SELECT * FROM `weixin_keywords` where id =$id");
			$smarty->assign ( 'keywords', $keywords );
			$smarty->display ( 'weixin/wx_keywordsedit.html' );
		}else{
			$diy_type = intval($_GET['t']);
			$key = getstr($_POST['key']);
			$condi = $diy_type > 0 ? "diy_type>0" : "diy_type=0";
			$condi .= $key ? " and (`key` like '%{$key}%' or `keys` like '%{$key}%' or `keyname` like '%{$key}%')" : "";
			$keywords = $GLOBALS['db']->getAll("SELECT * FROM `weixin_keywords` where {$condi}");
			$smarty->assign ( 'keywords', $keywords );
			if($diy_type > 0){
				$smarty->assign('action_link',  array('text' => "添加关键字回复", 'href'=>'weixin.php?act=addkey'));
				$smarty->display ( 'weixin/wx_keywords2.html' );
			}else{
				$smarty->display ( 'weixin/wx_keywords.html' );
			}
		}
		break;
	case "query":
	case "fans":
		$user_list = user_list();
		$smarty->assign('ur_here',      "fans管理");
	    $smarty->assign('user_list',    $user_list['user_list']);
	    $smarty->assign('filter',       $user_list['filter']);
	    $smarty->assign('record_count', $user_list['record_count']);
	    $smarty->assign('page_count',   $user_list['page_count']);
		if($_GET['is_ajax'] == 1){
			make_json_result($smarty->fetch('weixin/wx_fans.html'), '', array('filter' => $user_list['filter'], 'page_count' => $user_list['page_count']));
		}else{
		    $smarty->assign('full_page',    1);
			$smarty->display ( 'weixin/wx_fans.html' );
		}
		break;
	case "notice":
		if($_POST){
			$buynotice = intval($_POST ['buynotice']);
			$sendnotice = intval($_POST ['sendnotice']);
			$buymsg = getstr($_POST['buymsg']);
			$sendmsg = getstr($_POST['sendmsg']);
			$ret = $db->query (
					"UPDATE `weixin_config` SET
					`buymsg`='$buymsg',
					`sendmsg`='$sendmsg',
					`buynotice`='$buynotice',
					`sendnotice`='$sendnotice'
					WHERE `id`=1;" );
					$link [] = array ('href' => 'weixin.php?act=notice','text' => '提醒设置');
			if ($ret) {
					sys_msg ( '设置成功', 0, $link );
			} else {
				sys_msg ( '设置失败，请重试', 0, $link );
			}
		}else{
			$smarty->assign('ur_here',      "提醒设置");
			$ret = $db->getRow ( "SELECT * FROM `weixin_config` WHERE `id` = 1" );
			$smarty->assign ( 'buymsg', $ret ['buymsg'] );
			$smarty->assign ( 'sendmsg', $ret ['sendmsg'] );
			$smarty->assign ( 'buynotice', $ret ['buynotice'] );
			$smarty->assign ( 'sendnotice', $ret ['sendnotice'] );
			$smarty->display ( 'weixin/wx_notice.html' );
		}
		break;
	case "reg":
		if($_POST){
			$reg_type = intval($_POST ['reg_type']);
			$reg_notice = getstr($_POST['reg_notice']);
			$ret = $db->query (
					"UPDATE `weixin_config` SET
					`reg_notice`='$reg_notice',
					`reg_type`='$reg_type'
					WHERE `id`=1;" );
			$link [] = array ('href' => 'weixin.php?act=reg','text' => '注册设置');
			if ($ret) {
				sys_msg ( '设置成功', 0, $link );
			} else {
				sys_msg ( '设置失败，请重试', 0, $link );
			}
		}else{
			$smarty->assign('ur_here',      "注册设置");
			$ret = $db->getRow ( "SELECT * FROM `weixin_config` WHERE `id` = 1" );
			$smarty->assign ( 'reg_type', $ret ['reg_type'] );
			$smarty->assign ( 'reg_notice', $ret ['reg_notice'] );
			$smarty->display ( 'weixin/wx_reg.html' );
		}
		break;
	case "fansmsg":
		$fake_id = getstr($_REQUEST['fake_id']);
		if($_POST['content'] && $fake_id){
			$content = getstr($_POST['content']);
			$ret = pushToUserMsg($fake_id,'text',array('text'=>$content));
			$link [] = array ('href' => 'weixin.php?act=fansmsg&fake_id='.$fake_id,'text' => 'fans留言');
			if ($ret) {
			/* 代码增加_start  By www.68ecshop.com */
				$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : "/admin/";
$autoUrl = str_replace($_SERVER['REQUEST_URI'],"",$GLOBALS['ecs']->url());
@file_get_contents($autoUrl."/weixin/auto_do.php");
/* 代码增加_end  By www.68ecshop.com */

				sys_msg ( '操作成功', 0, $link );
			} else {
				sys_msg ( '操作失败，请重试', 0, $link );
			}
		}else{
			$smarty->assign('action_link',  array('text' => "fans管理", 'href'=>'weixin.php?act=fans'));
			$fake_id = getstr($_GET['fake_id']);
			if(!$fake_id){
				sys_msg ( '参数错误，请重试', 0, $link );
			}
			$sql = "select weixin_user.nickname,weixin_msg.* from weixin_msg 
				left join weixin_user on weixin_user.fake_id=weixin_msg.fake_id 
				where weixin_msg.fake_id='{$fake_id}' and weixin_msg.type='text' order by weixin_msg.msgid desc limit 50";
			$smarty->assign('msg_list', $db->getAll($sql));
			$smarty->assign('ur_here', "fans留言");
			$smarty->assign('fake_id', $fake_id);
			$smarty->display ( 'weixin/wx_fansmsg.html' );
		}
		break;
	case "qcode":
		$smarty->assign('action_link',  array('text' => "生成二维码", 'href'=>'weixin.php?act=addqcode'));
		$qcode_list = qcode_list();
		$smarty->assign('ur_here',      "二维码管理");
	    $smarty->assign('qcode_list',   $qcode_list['qcode_list']);
	    $smarty->assign('filter',       $qcode_list['filter']);
	    $smarty->assign('record_count', $qcode_list['record_count']);
	    $smarty->assign('page_count',   $qcode_list['page_count']);
		if($_GET['is_ajax'] == 1){
			make_json_result($smarty->fetch('weixin/wx_qcode.html'), '', array('filter' => $qcode_list['filter'], 'page_count' => $qcode_list['page_count']));
		}else{
		    $smarty->assign('full_page',    1);
			$smarty->display ( 'weixin/wx_qcode.html' );
		}
		break;
	case "addqcode":
		$id = intval($_REQUEST['id']);
		if($_GET['do'] == 'del' && $id>0){
			$link [] = array ('href' => 'weixin.php?act=qcode','text' => '二维码列表');
			$ret = $db->query("delete from weixin_qcode where id=$id");
			if ($ret) {
				sys_msg ( '删除成功', 0, $link );
			} else {
				sys_msg ( '删除失败，请重试', 0, $link );
			}
		}
		if($_POST){
			$type = intval($_POST['type']);
			if($type == 3){
				$content = getstr($_POST['content']);
			}else{
				$content = intval($_POST['content']);
			}
			if($content){
				if(!$id){
					$link [] = array ('href' => 'weixin.php?act=addqcode','text' => '生成二维码');
					require('../weixin/wechat.class.php');
					$config = $GLOBALS['db']->getRow ( "SELECT * FROM `weixin_config` WHERE `id` = 1" );
					$weixin = new core_lib_wechat($config);
					$scene_id = $db->getOne("select id from weixin_qcode order by id desc");
					$scene_id = $scene_id ? $scene_id+1 : 1;
					$qcode = $weixin->getQRCode($scene_id,1);
					$ret = $db->query("insert into weixin_qcode (`id`,`type`,`content`,`qcode`) value ($scene_id,$type,'$content','{$qcode['ticket']}')");
				}else{
					$ret = $db->query("update weixin_qcode set `type`='$type',`content`='$content' where id=$id");
					$link [] = array ('href' => 'weixin.php?act=qcode','text' => '二维码列表');
				}
			}
			if ($ret) {
				sys_msg ( '操作成功', 0, $link );
			} else {
				sys_msg ( '操作失败，请重试', 0, $link );
			}
		}else{
			$smarty->assign('action_link',  array('text' => "管理二维码", 'href'=>'weixin.php?act=qcode'));
			$ret = $db->getRow("select * from weixin_qcode where id=$id");
			$smarty->assign('ur_here', "生成二维码");
			$smarty->assign('qcode', $ret);
			$smarty->display ( 'weixin/wx_addqcode.html' );
		}
		break;
	case "news":
		$id = intval($_GET['id']);
		if($_POST){
			$artid = $_POST['artid'];
			$type = $_POST['msgtype']==1 ? "text" : "news";
			$sendtime = strtotime($_POST['sendtime']);
			if($sendtime<time()){
				$sendtime = time();
				//sys_msg ( '推送时间必须大于当前时间', 0, $link );
			}
			$createtime = time();
			if($_POST['msgtype']==1){
				if(preg_match('/[^\d,]+/', $_POST['artid'])){
					sys_msg ( '推送的文章不存在格式错误', 0, $link );
				}
				$artInfo = $db->getAll("select article_id,title,content,description,file_url from ".$ecs->table('article')." where article_id in($artid)");
				if(!$artInfo){
					sys_msg ( '推送的文章不存在', 0, $link );
				}
				$content = array(
						'touser'=>'',
						'msgtype'=>'news',
						'news'=>array('articles'=>$artInfo)
				);
			}else{
				$content = array(
						'touser'=>'',
						'msgtype'=>'text',
						'text'=>array('content'=>$_POST['artid'])
				);
			}
			$content = serialize($content);
			if($id){
				$sql = "update weixin_corn set sendtime='{$sendtime}',`content`='{$content}' where id=$id";
			}else{
				$sql = "insert into weixin_corn (`ecuid`,`content`,`createtime`,`sendtime`,`issend`,`sendtype`)
			value (0,'{$content}','{$createtime}','{$sendtime}','0','1')";
			}
			$GLOBALS['db']->query($sql);
			$link [] = array ('href' => 'weixin.php?act=newslist','text' => '推送列表');
			sys_msg ( "auto_do", 0, $link, false );
		}else{
			$smarty->assign('action_link',  array('text' => "推送列表", 'href'=>'weixin.php?act=newslist'));
			$smarty->assign('action_link2',  array('text' => "添加文章", 'href'=>'article.php?act=add'));
			$smarty->assign('ur_here', "消息推送");
			$ret = $db->getRow("select * from weixin_corn where id=$id");
			$content = unserialize($ret['content']);
			if($content['news']['articles']){
				foreach($content['news']['articles'] as $v){
					$artid .= $v['article_id'].",";
				}
				$smarty->assign('artid', rtrim($artid,","));
			}
			$ret['sendtime'] = $ret['sendtime'] ? $ret['sendtime'] :time()+3600;
			$smarty->assign('msgtype', $content['msgtype']);
			$smarty->assign('sendymd', date('Y-m-d H:i:s',$ret['sendtime']));
			$smarty->assign('corn', $ret);
			$smarty->display ( 'weixin/wx_addmsg.html' );
		}
		break;
	case "newslist":
		$smarty->assign('action_link',  array('text' => "消息推送", 'href'=>'weixin.php?act=news'));
		$ret = $db->getAll("select * from weixin_corn where sendtype=1 and issend=0");
		if($ret){
			foreach ($ret as $k=>$v){
				$ret[$k]['sendymd'] = date("Y-m-d H:i:s",$v['sendtime']);
				$news = unserialize($v['content']);
				if($news['news']['articles']){
					foreach($news['news']['articles'] as $v){
						$ret[$k]['title'] .= "<a href='article.php?act=edit&id={$v['article_id']}' target='_blank'>{$v['title']}</a><br>";
					}
				}else{
					$ret[$k]['title'] = $news['text']['content'];
				}
			}
		}
		$smarty->assign('ur_here', "推送列表");
		$smarty->assign('corn', $ret);
		$smarty->display ( 'weixin/wx_newslist.html' );
		break;
	case "view":
		$id = intval($_GET['id']);
		$ret = $db->getRow("select * from weixin_corn where id={$id}");
		if($ret){
			$smarty->assign('ur_here', "发送内容预览");
			$content = unserialize($ret['content']);
			$smarty->assign('corn', $content['news']['articles']);
			$smarty->assign('msgtype', $content['msgtype']);
			$smarty->assign('content', $content['text']);
			$smarty->display ( 'weixin/wx_newsview.html' );
		}else{
			sys_msg ( '记录不存在', 0, $link );
		}
		break;
	case "addconfig":
		$id = intval($_REQUEST['id']);
		$token = getstr($_POST ['token']);
		$appid = getstr($_POST ['appid']);
		$appsecret = getstr($_POST ['appsecret']);
		if($id > 1) $smarty->assign('config',$db->getRow("SELECT * FROM `weixin_config` WHERE id={$id}"));
		if($id > 1 && $_GET['up'] == 1){
			update_menu($id);
			$link [] = array ('href' => 'weixin.php?act=addconfig','text' => '多帐号管理');
			sys_msg ( '操作成功', 0, $link );
		} 
		if($_POST){
			if($id > 1){
				$ret = $db->query("UPDATE `weixin_config` SET `token`='$token',`appid`='$appid',`appsecret`='$appsecret' WHERE `id`={$id}" );
			}else{
				$ret = $db->query("INSERT INTO `weixin_config` (`token`,`appid`,`appsecret`) VALUE ('$token','$appid','$appsecret')");
			}
			$link [] = array ('href' => 'weixin.php?act=addconfig','text' => '多帐号管理');
			sys_msg ( '操作成功', 0, $link );
		}else{
			$baseurl = $_SERVER['SERVER_NAME'] ? "http://".$_SERVER['SERVER_NAME']."/" : "http://".$_SERVER['HTTP_HOST']."/";
			$smarty->assign('baseurl',$baseurl);
			$smarty->assign('list', $db->getAll("SELECT * FROM `weixin_config` WHERE id>1"));
			$smarty->display ( 'weixin/wx_addconfig.html' );
		}
		break;
	case "oauth":
		//$smarty->assign('configlist',$db->getAll("SELECT * FROM `weixin_config`"));
		if($_GET['t'] == 'add'){
			$oid = intval($_GET['oid']);
			$id = intval($_POST['id']);
			if($_POST){
				$weburl = $_POST['weburl'];
				if($oid > 0){
					$ret = $db->query("UPDATE `weixin_oauth` SET `weburl`='$weburl',`id`=$id WHERE `oid`={$oid}" );
				}else{
					$ret = $db->query("INSERT INTO `weixin_oauth` (`weburl`,`click`,`id`) VALUE ('$weburl',0,$id)");
				}
				$link [] = array ('href' => 'weixin.php?act=oauth','text' => 'oauth管理');
				sys_msg ( '操作成功', 0, $link );
			}else{
				$oauth = $db->getRow("select * from weixin_oauth where oid={$oid}");
				$smarty->assign('oauth',$oauth);
				$smarty->display ( 'weixin/oauth_add.html' );
			}
		}else{
			$smarty->assign('action_link',  array('text' => "添加oauth跳转", 'href'=>'weixin.php?act=oauth&t=add'));
			$baseurl = $_SERVER['SERVER_NAME'] ? "http://".$_SERVER['SERVER_NAME']."/" : "http://".$_SERVER['HTTP_HOST']."/";
			$smarty->assign('baseurl',$baseurl);
			$oauth = $db->getAll("select * from weixin_oauth");
			$smarty->assign('oauth',$oauth);
			$smarty->display ( 'weixin/oauth_list.html' );
		}
		break;
	case "qiandao":
		if($_POST){
			$startymd = getstr($_POST['startymd']);
			$endymd = getstr($_POST['endymd']);
			$num = intval($_POST['num']);
			$bignum = intval($_POST['bignum']);
			$addnum = intval($_POST['addnum']);
			$ret = $db->query("UPDATE `weixin_signconf` SET 
			`startymd`='$startymd',
			`endymd`='$endymd',
			`num`='$num',
			`bignum`='$bignum',
			`addnum`='$addnum'
			WHERE `cid`=1" );
			$link [] = array ('href' => 'weixin.php?act=qiandao','text' => '签到管理');
			sys_msg ( '操作成功', 0, $link );
		}else{
			$sign = $db->getRow("select * from weixin_signconf where cid=1");
			$smarty->assign('sign',$sign);
			$smarty->display ( 'weixin/qiandao_add.html' );
		}
		break;
	case "addkey":
		$id = intval($_REQUEST['id']);
		if($_POST){
			require_once(ROOT_PATH . 'includes/cls_image.php');
			$diy_type = intval($_POST['diy_type'])==2 ? 2 : 1;
			$_POST['description'] = $_POST["description{$diy_type}"];
			$_POST['title'] = $_POST['title'] ? $_POST['title'] : " ";
			$diy_value = "article_".addNews();
			$key = getstr($_POST['key']);
			$keys = getstr($_POST['keys']);
			$keyname = getstr($_POST['keyname']);
			if($id > 0){
				$ret = $db->query("UPDATE `weixin_keywords` SET `diy_value`='$diy_value',`key`='$key',`keys`='$keys',`keyname`='$keyname',`diy_type`=$diy_type WHERE `id`={$id}" );
			}else{
				$ret = $db->query("INSERT INTO `weixin_keywords` 
				(`diy_value`,`key`,`keys`,`keyname`,`diy_type`,`jf_type`,`jf_num`,`jf_maxnum`,`clicks`) VALUE 
				('$diy_value','$key','$keys','$keyname','$diy_type',0,0,0,0)");
			}
			$link [] = array ('href' => 'weixin.php?act=addkey','text' => '继续添加');
			$link [] = array ('href' => 'weixin.php?act=keywords&t=1','text' => '关键字管理');
			sys_msg ( '操作成功', 0, $link );
		}else{
			$smarty->assign('action_link',  array('text' => "关键字管理", 'href'=>'weixin.php?act=keywords&t=1'));
			$smarty->assign('ur_here',"添加自定义回复");
			if($id > 0){
				$keywords = $db->getRow ( "SELECT * FROM `weixin_keywords` WHERE `id` = $id" );
				$articleId = str_replace('article_','',$keywords['diy_value']);
				$artInfo = $db->getRow("select * from ".$ecs->table('article')." where article_id='{$articleId}'");
				$smarty->assign ( 'keywords', $keywords );
				$smarty->assign ( 'article', $artInfo );
			}
			$smarty->display ( 'weixin/wx_addkey.html' );
		}
		break;
}

function getstr($str){
	return htmlspecialchars($str,ENT_QUOTES);
}

function user_list()
{
    $result = get_filter();
    if ($result === false)
    {
        $filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
        $tn = $GLOBALS['ecs']->table('users');
        $ex_where = ' WHERE 1 ';
        if ($filter['keywords'])
        {
            $key = "%".getstr($filter['keywords'])."%";
        	$ex_where .= " AND (weixin_user.nickname LIKE '{$key}' or weixin_user.fake_id LIKE '{$key}' or {$tn}.user_name LIKE '{$key}') ";
        }
        $leftJoin = " left join {$tn} on {$tn}.user_id=weixin_user.ecuid ";
        $filter['record_count'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM weixin_user " . $leftJoin . $ex_where);
        $filter = page_and_size($filter);
        $sql = "SELECT weixin_user.*,{$tn}.user_name FROM weixin_user " . $leftJoin . $ex_where .
                " LIMIT " . $filter['start'] . ',' . $filter['page_size'];
        $filter['keywords'] = stripslashes($filter['keywords']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $user_list = $GLOBALS['db']->getAll($sql);
    $arr = array('user_list' => $user_list, 'filter' => $filter,
        'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
    return $arr;
}

function update_menu($id=1){
	require('../weixin/wechat.class.php');
	$config = $GLOBALS['db']->getRow ( "SELECT * FROM `weixin_config` WHERE `id` = {$id}" );
	$weixin = new core_lib_wechat($config);
	$ret = $GLOBALS['db']->getAll ( "SELECT * FROM `weixin_menu` where pid=0 order by `order` desc" );
	if($ret){
		foreach($ret as $k=>$v){
			$button[$k]['name'] = $v['name'];
			$ret2 = $GLOBALS['db']->getAll ( "SELECT * FROM `weixin_menu` where pid={$v['id']} order by `order` desc" );
			if($ret2){
				foreach($ret2 as $kk=>$vv){
					$button[$k]['sub_button'][$kk]['name'] = $vv['name'];
					if($vv['type'] == 1){
						$button[$k]['sub_button'][$kk]['key'] = $vv['value'];
						$button[$k]['sub_button'][$kk]['type'] = "click";
					}elseif($vv['type'] == 3){
						$button[$k]['sub_button'][$kk]['key'] = $vv['value'];
						$button[$k]['sub_button'][$kk]['type'] = "click";
					}else{
						$vv['value'] = str_replace('{id}', $id, $vv['value']);
						$button[$k]['sub_button'][$kk]['url'] = $vv['value'];
						$button[$k]['sub_button'][$kk]['type'] = "view";
					}
				}
			}else{
				if($v['type'] == 1){
					$button[$k]['key'] = $v['value'];
					$button[$k]['type'] = "click";
				}else{
					$v['value'] = str_replace('{id}', $id, $v['value']);
					$button[$k]['url'] = $v['value'];
					$button[$k]['type'] = "view";
				}
			}
		}
	}
	$res = $weixin->createMenu(array('button'=>$button));
	if($res === false){
		sys_msg ( '更新菜单出错：'.$weixin->errMsg, 1, $link );
	}else{
		return true;
	}
}

function pushToUserMsg($fake_id,$type="text",$msg=array(),$sendtime=0){
	$user = $GLOBALS['db']->getRow("select * from weixin_user where fake_id='{$fake_id}'");
	if($user && $user['fake_id'] && $user['isfollow'] == 1){
		if($type == 'text'){
			$content = array(
					'touser'=>$user['fake_id'],
					'msgtype'=>'text',
					'text'=>array('content'=>$msg['text'])
			);
		}
		if($type == 'news'){
			$content = array(
					'touser'=>$user['fake_id'],
					'msgtype'=>'news',
					'news'=>array('articles'=>$msg)
			);
		}
		$content = serialize($content);
		$sendtime = $sendtime ? $sendtime : time();
		$createtime = time();
		$sql = "insert into weixin_corn (`ecuid`,`content`,`createtime`,`sendtime`,`issend`)
		value ({$user['ecuid']},'{$content}','{$createtime}','{$sendtime}','0')";
		$GLOBALS['db']->query($sql);
		return true;
	}else{
		$GLOBALS['err']->add("用户未关注");
		return false;
	}
}

function qcode_list()
{
	$result = get_filter();
	if ($result === false)
	{
		$filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
		$filter['type'] = empty($_REQUEST['type']) ? 1 : intval($_REQUEST['type']);
		$ex_where = " where weixin_qcode.type={$filter['type']}";
		if ($filter['keywords']){
			$key = "%".getstr($filter['keywords'])."%";
			$ex_where = " and (weixin_qcode.content like '{$key}' ";
		}
		if($filter['type'] == 1){
			$tn = $GLOBALS['ecs']->table('goods');
			$leftJoin = " left join {$tn} on weixin_qcode.content={$tn}.goods_id";
			$items = "weixin_qcode.*,$tn.goods_name as title";
			if($key) $ex_where .= " or {$tn}.goods_name like '{$key}')";
		}elseif($filter['type'] == 2){
			$tn = $GLOBALS['ecs']->table('article');
			$leftJoin = " left join {$tn} on weixin_qcode.content={$tn}.article_id";
			$items = "weixin_qcode.*,$tn.title";
			if($key) $ex_where .= " or {$tn}.title like '{$key}')";
		}else{
			$leftJoin = "";
			$items = "*";
			if($key) $ex_where .= ")";
		}
		$filter['record_count'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM weixin_qcode ".$leftJoin . $ex_where);
		$filter = page_and_size($filter);
		$sql = "SELECT {$items} FROM weixin_qcode " .$leftJoin. $ex_where .
		" LIMIT " . (int)$filter['start'] . ',' . (int)$filter['page_size'];
		$filter['keywords'] = stripslashes($filter['keywords']);
		set_filter($filter, $sql);
	}
	else
	{
		$sql    = $result['sql'];
		$filter = $result['filter'];
	}
	$user_list = $GLOBALS['db']->getAll($sql);
	$arr = array('qcode_list' => $user_list, 'filter' => $filter,
			'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	return $arr;
}

function addNews(){
    $file_url = '';
    if ((isset($_FILES['file']['error']) && $_FILES['file']['error'] == 0) || (!isset($_FILES['file']['error']) && isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != 'none'))
    {
        if (!check_file_type($_FILES['file']['tmp_name'], $_FILES['file']['name'], $allow_file_types))
        {
            sys_msg($_LANG['invalid_file']);
        }

        $res = upload_article_file($_FILES['file']);
        if ($res != false)
        {
            $file_url = $res;
        }
    }
	if(!$file_url && $_POST['article_id']){
		$file_url = $_POST['file_url'];
	}
    $open_type = 2;
    /*插入数据*/
    $add_time = gmtime();
	$_POST['cat_id'] = 0;
    if(!$_POST['article_id']){
		$sql = "INSERT INTO ".$GLOBALS['ecs']->table('article')."(title, cat_id, article_type, is_open, author, ".
					"author_email, keywords, content, add_time, file_url, open_type, link, description) ".
				"VALUES ('$_POST[title]', '$_POST[article_cat]', '0', '1', ".
					"'', '', '', '{$_POST['description']}', ".
					"'$add_time', '$file_url', '$open_type', '{$_POST['link_url']}', '{$_POST['description']}')";
		$GLOBALS['db']->query($sql);
		return $GLOBALS['db']->insert_id();
	}else{
		$aid = (int)$_POST['article_id'];
		$GLOBALS['db']->query("update ".$GLOBALS['ecs']->table('article')." set 
		title='{$_POST[title]}',file_url='$file_url',link='{$_POST['link_url']}',description='{$_POST['description']}' where article_id=$aid");
		return $aid;
	}
}
/* 上传文件 */
function upload_article_file($upload){
    if (!make_dir("../" . DATA_DIR . "/article"))
    {
        /* 创建目录失败 */
        return false;
    }
    $filename = cls_image::random_filename() . substr($upload['name'], strpos($upload['name'], '.'));
    $path     = ROOT_PATH. DATA_DIR . "/article/" . $filename;
    if (move_upload_file($upload['tmp_name'], $path))
    {
        return DATA_DIR . "/article/" . $filename;
    }
    else
    {
        return false;
    }
}