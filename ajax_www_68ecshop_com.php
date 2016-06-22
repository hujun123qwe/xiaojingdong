<?php

/**
 * ECSHOP ajax
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: www.68ecshop.com $
 * $Id: ajax.php 17063 2010-03-25 06:35:46Z qq $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ($_REQUEST['act'] == 'tipword')
{
	require(ROOT_PATH . 'includes/cls_json.php');
	$word_www_68ecshop_com = json_str_iconv($_REQUEST['word']);
	$json_www_68ecshop_com   = new JSON;
	$result_www_68ecshop_com = array('error' => 0, 'message' => '', 'content' => '');
	
	if(!$word_www_68ecshop_com || strlen($word_www_68ecshop_com) < 2 || strlen($word_www_68ecshop_com) > 30)
	{
        $result_www_68ecshop_com['error']   = 1;
		die($json_www_68ecshop_com->encode($result_www_68ecshop_com));
	}
	$needle = $replace = array();
	$word_www_68ecshop_com = str_replace(array(' ','*', "\'"), array('%', '%', ''), $word_www_68ecshop_com);
	$needle[] = $word_www_68ecshop_com;
	$replace[] = '<strong style="color:cc0000;">'.$word_www_68ecshop_com.'</strong>';
	$logdb = array();
	if(preg_match("/^[a-z0-9A-Z]+$/", $word_www_68ecshop_com)) {	
    	$sql_qq = "SELECT * FROM " . $ecs->table('keyword') ." WHERE searchengine='ecshop' AND status='1' AND letter LIKE '%$word_www_68ecshop_com%' ORDER BY total_search DESC";
	} else {
    	$sql_qq = "SELECT * FROM " . $ecs->table('keyword') ." WHERE searchengine='ecshop' AND status='1' AND word LIKE '%$word_www_68ecshop_com%' ORDER BY total_search DESC";
	}
    $res_www_68ecshop_com = $db->SelectLimit($sql_qq, 10, 0);

	$iii=1; //68ecshop.com
	while ($rows_www_68ecshop_com = $db->fetchRow($res_www_68ecshop_com))
    {
		$rows_www_68ecshop_com['kword'] = str_ireplace($needle, $replace, $rows_www_68ecshop_com['word']);

		/* start  By  68ecshop.com */
		if($iii==1 && $rows_www_68ecshop_com['keyword_cat_count'])
		{  
			$rows_www_68ecshop_com['keyword_cat'] =  '<a href="' . $rows_www_68ecshop_com['keyword_cat_url'] . '"><font color=#666>在<font color=#cc0000>'. $rows_www_68ecshop_com['keyword_cat'] .'</font>分类中搜索</font></a>';
			$rows_www_68ecshop_com['keyword_cat_count'] = intval($rows_www_68ecshop_com['keyword_cat_count']);
		}
		$iii=$iii+1;  
		/* end  By  68ecshop.com */

		$logdb[] = $rows_www_68ecshop_com; 

		
	}
	$smarty->assign('logdb', $logdb);
	$result_www_68ecshop_com['content'] = $smarty->fetch('library/search_tip.lbi');
	die($json_www_68ecshop_com->encode($result_www_68ecshop_com));
}
?>