<?php

/**
 * 店铺的控制器文件
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


require(dirname(__FILE__) . '/includes/init_supplier.php');


if($_GET['suppId']<=0){
	
	ecs_header("Location: index.php");
    exit;
}
$sql="SELECT s.*,sr.rank_name FROM ". $ecs->table("supplier") . " as s left join ". $ecs->table("supplier_rank") ." as sr ON s.rank_id=sr.rank_id
 WHERE s.supplier_id=".$_GET['suppId']." AND s.status=1";
$suppinfo=$db->getRow($sql);
$smarty->assign('suppid', $suppinfo['supplier_id']);
if(empty($suppinfo['supplier_id']) || $_GET['suppId'] != $suppinfo['supplier_id'])
{
	 ecs_header("Location: index.php");
     exit;
}

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}
$typeinfo = array('index','category','search','article','other','about');
$go = (isset($_GET['go']) && !empty($_GET['go'])) ? $_GET['go'] : 'index';
if(!in_array($go,$typeinfo)){
	ecs_header("Location: index.php");
    exit;
}else{
	require(dirname(__FILE__) . '/supplier_'.$go.'.php');
}

?>