<?php
define ( 'IN_ECS', true );
require (dirname ( __FILE__ ) . '/includes/init.php');
$act = trim ( $_REQUEST ['act'] );
switch ($act){
	case "list"://list
		$act = $db->getRow ( "SELECT * FROM `weixin_act` where aid=1" );
		$smarty->assign ( 'act', $act );
		$aid = intval($_GET['aid']);
		if($aid == 1){
			if($_POST){
				$title = getstr($_POST ['title']);
				$content = getstr($_POST ['content']);
				$isopen = intval($_POST ['isopen']);
				$type = intval($_POST ['type']);
				$num = intval($_POST ['num']);
				$ret = $db->query ( 
					"UPDATE `weixin_act` SET 
					`title`='$title',
					`content`='$content',
					`isopen`='$isopen',
					`type`='$type',
					`num`='$num'
					 WHERE `aid`=1;" );
				$link [] = array ('href' => 'weixin_egg.php?act=list','text' => '活动管理');
				sys_msg ( '修改成功', 0, $link );
			}else{
				$smarty->display ( 'weixin/act_show.html' );
				return;
			}
		}
		$smarty->display ( 'weixin/act_list.html' );
		break;
	case "listall":
		$aid = intval($_GET['aid']);
		$actList = $db->getAll ( "SELECT * FROM `weixin_actlist` where aid=$aid" );
		$smarty->assign ( 'actList', $actList );
		$smarty->display ( 'weixin/act_listall.html' );
		break;
	case "add"://add and edit
		$lid = intval($_GET['lid']);
		$title = getstr($_POST ['title']);
		$awardname = getstr($_POST ['awardname']);
		$randnum = round($_POST ['randnum'],2);
		$isopen = intval($_POST ['isopen']);
		$num = intval($_POST ['num']);
		if($lid > 0){
			$actList = $db->getRow ( "SELECT * FROM `weixin_actlist` where lid=$lid" );
			$smarty->assign ( 'actList', $actList );
			$sql = "update weixin_actlist set title='$title',randnum=$randnum,num=$num,isopen=$isopen,awardname='$awardname' where lid=$lid";
		}else{
			$sql = "insert into weixin_actlist (title,randnum,isopen,num,aid,awardname) 
			value ('$title','$randnum','$isopen','$num',1,'$awardname')";
		}
		if($_POST){
			$ret = $db->query($sql);
			$link [] = array ('href' => 'weixin_egg.php?act=list','text' => '活动管理');
			sys_msg ( '处理成功', 0, $link );
		}else{
			$smarty->display ( 'weixin/act_add.html' );
		}
		break;
	case "log":
		$lid = intval($_GET['lid']);
		if($lid > 0){
			$ret = $db->query("update weixin_actlog set issend=1 where lid=$lid");
			$link [] = array ('href' => 'weixin_egg.php?act=log','text' => '获奖管理');
			sys_msg ( '处理成功', 0, $link );
		}
		$sql = "SELECT weixin_actlog.*,weixin_user.nickname FROM `weixin_actlog` 
		left join weixin_user on weixin_actlog.uid=weixin_user.ecuid 
		where code!='' order by lid desc";
		$log = $db->getAll ( $sql );
		$smarty->assign ( 'log', $log );
		$smarty->display ( 'weixin/act_log.html' );
		break;
}

function getstr($str){
	return htmlspecialchars($str,ENT_QUOTES);
}