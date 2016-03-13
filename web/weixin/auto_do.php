<?php
require(dirname(__FILE__) . '/api.class.php');
require(dirname(__FILE__) . '/wechat.class.php');
$baseurl = $_SERVER['SERVER_NAME'] ? "http://".$_SERVER['SERVER_NAME']."/" : "http://".$_SERVER['HTTP_HOST']."/";
$t = time();
$type = intval($_GET['type']);
$rs = $db->getRow ( "SELECT * FROM `weixin_corn` WHERE `issend` = 0 and `sendtype`={$type} order by sendtime desc" );
if($rs){
	$weixinconfig = $db->getRow ( "SELECT * FROM `weixin_config` WHERE `id` = 1" );
	$weixin = new core_lib_wechat($weixinconfig);
	$content = unserialize($rs['content']);
	$msg = array();
	$msg['msgtype'] = $content['msgtype'];
	if($content['msgtype'] == 'news'){
		foreach($content['news']['articles'] as $k=>$v){
			$msg['news']['articles'][$k]['title'] = $v['title'];
			$msg['news']['articles'][$k]['description'] = $v['description'];
			$msg['news']['articles'][$k]['url'] = $baseurl."mobile/article.php?id=".$v['article_id'];
			$msg['news']['articles'][$k]['picurl'] = strpos($v['file_url'], 'http://') == false ? $baseurl.$v['file_url'] : $v['file_url'];
		}
	}else{
		$msg = $content;
	}
	if($type == 1){
		$user = $db->getAll("SELECT fake_id FROM `weixin_user` WHERE isfollow=1 and access_token!='' and expire_in>'{$t}' order by expire_in desc");
	}else{
		$user = array(array('fake_id'=>$content['touser']));
	}
	if($user){
		foreach($user as $u){
			$msg['touser'] = $u['fake_id'];
			$ret = $weixin->sendCustomMessage($msg);
			if(!$_GET['ajax']) var_dump($ret);
		}
		$db->query("UPDATE weixin_corn SET issend=2 where id ={$rs['id']}");
	}
	if($_GET['ajax'] == 1){
		$result = array('error'=>0,'content'=>'');
		echo json_encode($result);
	}
}