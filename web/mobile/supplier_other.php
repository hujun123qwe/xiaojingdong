<?php

/**
 * 店铺 首页文件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: index.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);
//判断是否有ajax请求
$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($act == 'add_guanzhu')
{
	
	$user_id = intval($_SESSION['user_id']);
	
    
    include_once('includes/cls_json.php');
    $json = new JSON;
    $result   = array('error' => 0, 'info' => '', 'data'=>'');
    
	if(empty($user_id)){
		$result['info'] = '请先登陆！';
		die($json->encode($result));
	}
	try {
		$sql = 'INSERT INTO '. $ecs->table('supplier_guanzhu') . ' (`userid`, `supplierid`, `addtime`) VALUES ('.$user_id.','.$_GET['suppId'].','.time().') ON DUPLICATE KEY UPDATE addtime='.time();
		$db->query($sql);
		if($db->affected_rows() > 1){
			$result['error'] = 2;
    		$result['info'] = '已经收藏！';
		}else{
			$result['error'] = 1;
    		$result['info'] = '收藏成功！';
		}
	} catch (Exception $e) {
		$result['error'] = 2;
    	$result['info'] = '已经收藏！';
	}
   echo json_encode($result);
}


?>